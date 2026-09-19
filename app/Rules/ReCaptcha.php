<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class ReCaptcha implements ValidationRule
{
    public function __construct(private readonly string $expectedAction)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secretKey = (string) config('services.recaptcha.secret_key');

        if ($secretKey === '' || ! is_string($value) || $value === '') {
            $fail('We could not verify that you are human. Please refresh the page and try again.');

            return;
        }

        try {
            $response = Http::asForm()
                ->timeout((int) config('services.recaptcha.timeout', 5))
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secretKey,
                    'response' => $value,
                    'remoteip' => request()->ip(),
                ]);
        } catch (Throwable $exception) {
            Log::warning('Google reCAPTCHA verification request failed.', [
                'error' => $exception->getMessage(),
            ]);

            $fail('We could not verify that you are human. Please try again.');

            return;
        }

        $result = $response->json();
        $hasValidPayload = is_array($result);
        $result = $hasValidPayload ? $result : [];
        $minimumScore = (float) config('services.recaptcha.minimum_score', 0.5);
        $actionMatches = is_string($result['action'] ?? null)
            && hash_equals($this->expectedAction, $result['action']);

        if (
            ! $response->successful()
            || ! $hasValidPayload
            || ($result['success'] ?? false) !== true
            || ! $actionMatches
            || (float) ($result['score'] ?? 0) < $minimumScore
        ) {
            Log::notice('Google reCAPTCHA rejected a frontend form submission.', [
                'action' => $result['action'] ?? null,
                'expected_action' => $this->expectedAction,
                'score' => $result['score'] ?? null,
                'error_codes' => $result['error-codes'] ?? [],
            ]);

            $fail('We could not verify that you are human. Please try again.');
        }
    }
}

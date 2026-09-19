<?php

namespace Tests\Unit;

use App\Rules\ReCaptcha;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ReCaptchaTest extends TestCase
{
    public function test_it_accepts_a_successful_response_with_the_expected_action_and_score(): void
    {
        config()->set([
            'services.recaptcha.secret_key' => 'test-secret',
            'services.recaptcha.minimum_score' => 0.5,
        ]);

        Http::fake([
            'www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => true,
                'score' => 0.9,
                'action' => 'contact_form',
            ]),
        ]);

        $errors = $this->validateToken('contact_form');

        $this->assertSame([], $errors);
        Http::assertSent(fn ($request) => $request['secret'] === 'test-secret'
            && $request['response'] === 'test-token');
    }

    public function test_it_rejects_a_token_for_a_different_action(): void
    {
        config()->set([
            'services.recaptcha.secret_key' => 'test-secret',
            'services.recaptcha.minimum_score' => 0.5,
        ]);

        Http::fake([
            'www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => true,
                'score' => 0.9,
                'action' => 'career_form',
            ]),
        ]);

        $this->assertNotEmpty($this->validateToken('contact_form'));
    }

    public function test_it_rejects_a_token_below_the_minimum_score(): void
    {
        config()->set([
            'services.recaptcha.secret_key' => 'test-secret',
            'services.recaptcha.minimum_score' => 0.5,
        ]);

        Http::fake([
            'www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => true,
                'score' => 0.4,
                'action' => 'contact_form',
            ]),
        ]);

        $this->assertNotEmpty($this->validateToken('contact_form'));
    }

    public function test_it_fails_closed_when_the_secret_is_not_configured(): void
    {
        config()->set('services.recaptcha.secret_key', null);
        Http::fake();

        $this->assertNotEmpty($this->validateToken('contact_form'));
        Http::assertNothingSent();
    }

    public function test_it_rejects_a_malformed_verification_response(): void
    {
        config()->set('services.recaptcha.secret_key', 'test-secret');

        Http::fake([
            'www.google.com/recaptcha/api/siteverify' => Http::response('not-json'),
        ]);

        $this->assertNotEmpty($this->validateToken('contact_form'));
    }

    /**
     * @return array<int, string>
     */
    private function validateToken(string $expectedAction): array
    {
        $errors = [];

        (new ReCaptcha($expectedAction))->validate(
            'recaptcha_token',
            'test-token',
            function (string $message) use (&$errors): void {
                $errors[] = $message;
            }
        );

        return $errors;
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FrontendRecaptchaTest extends TestCase
{
    public function test_contact_form_requires_a_recaptcha_token(): void
    {
        $response = $this->from(route('contact-us'))->post(route('contact-us'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'subject' => 'Test enquiry',
            'description' => 'This is a test enquiry.',
        ]);

        $response
            ->assertRedirect(route('contact-us'))
            ->assertSessionHasErrors('recaptcha_token');
    }

    public function test_career_form_requires_a_recaptcha_token(): void
    {
        $response = $this->from(route('career'))->post(route('career'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'position' => 'Engineer',
            'resume' => UploadedFile::fake()->createWithContent('resume.pdf', '%PDF-1.4 test'),
        ]);

        $response
            ->assertRedirect(route('career'))
            ->assertSessionHasErrors('recaptcha_token');
    }
}

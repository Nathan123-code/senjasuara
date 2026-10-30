<?php

use App\Mail\RegistrationEmail;
use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('a visitor can submit a ticket registration', function () {
    Mail::fake();

    $response = $this->post(route('registrations.store'), [
        'name' => 'Naya Putri',
        'email' => 'naya@example.com',
        'phone' => '081234567890',
        'ticket_type' => 'vip',
        'quantity' => 2,
        'consent' => '1',
    ]);

    $response->assertRedirect(route('registrations.create'));
    $response->assertSessionHas('success');
    Mail::assertSent(RegistrationEmail::class, function (RegistrationEmail $mail) {
        return $mail->hasTo('naya@example.com')
            && $mail->registration->name === 'Naya Putri'
            && $mail->registration->phone === '081234567890';
    });

    expect(Registration::first()->only([
        'name',
        'email',
        'phone',
        'ticket_type',
        'quantity',
        'total_amount',
    ]))->toMatchArray([
        'name' => 'Naya Putri',
        'email' => 'naya@example.com',
        'phone' => '081234567890',
        'ticket_type' => 'vip',
        'quantity' => 2,
        'total_amount' => 1000000,
    ]);
});

test('the registration email contains the users data', function () {
    $registration = Registration::factory()->create([
        'name' => 'Naya Putri',
        'email' => 'naya@example.com',
        'phone' => '081234567890',
    ]);

    $mail = new RegistrationEmail($registration);

    $mail->assertSeeInHtml('Naya Putri');
    $mail->assertSeeInHtml('naya@example.com');
    $mail->assertSeeInHtml('081234567890');
});

test('a registration requires valid form data', function () {
    $response = $this->post(route('registrations.store'), []);

    $response->assertSessionHasErrors([
        'name',
        'email',
        'phone',
        'ticket_type',
        'quantity',
        'consent',
    ]);

    expect(Registration::count())->toBe(0);
});

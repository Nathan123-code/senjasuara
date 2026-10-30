<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationEmail;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    /**
     * Ticket prices in rupiah, keyed by the public ticket type.
     *
     * @var array<string, int>
     */
    private const TICKET_PRICES = [
        'early-bird' => 150000,
        'presale' => 250000,
        'vip' => 500000,
    ];

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'ticket_type' => ['required', 'string', 'in:early-bird,presale,vip'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
            'consent' => ['accepted'],
        ]);

        $totalAmount = self::TICKET_PRICES[$validated['ticket_type']] * $validated['quantity'];

        $registration = Registration::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'ticket_type' => $validated['ticket_type'],
            'quantity' => $validated['quantity'],
            'total_amount' => $totalAmount,
        ]);

        Mail::to($registration->email)->send(new RegistrationEmail($registration));

        return redirect()
            ->route('registrations.create')
            ->with('success', 'Pendaftaran berhasil disimpan.');
    }
}

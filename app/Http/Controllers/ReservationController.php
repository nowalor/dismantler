<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Services\FenixApiService;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function __construct(private FenixApiService $fenixApiService)
    {
    }

    public function show(Reservation $reservation) : View
    {
        $reservation->load('carPart.carPartImages');

        return view('reservations.show', compact('reservation'));
    }

    public function destroy(Reservation $reservation)//: RedirectResponse
    {
        $reservation->load('carPart');

        if(!$this->fenixApiService->hasReservation($reservation->reservation_id)) {
            return redirect()->back()->with(
                'error',
                'Reservation not found. Maybe it was already removed?'
            );
        }

        $this->fenixApiService->removeReservation($reservation);

        if($this->fenixApiService->hasReservation($reservation->reservation_id)) {
            return redirect()->back()->with(
                'error',
                'Something went wrong and the reservation could not be removed.'
            );
        }

        $reservation->is_active = false;
        $reservation->save();

        return redirect()->back()->with(
            'success',
            'Reservation removed successfully.'
        );
    }
}

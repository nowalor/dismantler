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

    public function show(Reservation $reservation)// : View
    {
        $reservation->load('carPart.carPartImages');

        return view('reservations.show', compact('reservation'));
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->load('carPart');

        if(!$this->fenixApiService->hasReservation($reservation->reservation_id)) {
            return 'Reservation does not exist';
        }

        $this->fenixApiService->removeReservation($reservation);

        if($this->fenixApiService->hasReservation($reservation->reservation_id)) {
            return 'Reservation still exists';
        }

        $reservation->is_active = false;

        return 'worked??';
    }
}

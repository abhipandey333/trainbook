<?php

namespace App\Http\Controllers;

use App\Models\TrainSeat;
use Illuminate\Http\Request;

class TicketBookController extends Controller
{
    public $totalSeats = 80;

    const MAXIMUM_SEATS_BOOK_IN_ONE_TIME = 7;
    const CONSTANT_FOR_ONE = 1;

    /**
     * This function for getting left seats count and render view.
     */
    public function view()
    {
        $bookedSeatsCount = TrainSeat::sum('seats_count');
        $totalSeats = $this->totalSeats - $bookedSeatsCount;
        $maximumSeatsInOneTime = self::MAXIMUM_SEATS_BOOK_IN_ONE_TIME;
        if ($totalSeats <= $maximumSeatsInOneTime) {
            $maximumSeatsInOneTime = $totalSeats;
        }
        return view('welcome', compact([
            'totalSeats',
            'maximumSeatsInOneTime'
        ]));
    }

    /**
     * This function for save seats and show booked seat along with their no.
     */
    public function book(Request $request)
    {
        $booked = TrainSeat::create([
            'seats_count' => $request->seats
        ]);

        $bookedSeatsCount = TrainSeat::where('id', '!=', $booked->id)->sum('seats_count');
        if ($request->seats == self::CONSTANT_FOR_ONE) {
            $bookedSeats = "Your ticket is booked with seat no: B" . $bookedSeatsCount + self::CONSTANT_FOR_ONE;
        } else {
            $seatsNo = [];
            for ($i = 0; $i < $request->seats; $i++) {
                $seatsNo[] = "B" . $bookedSeatsCount + self::CONSTANT_FOR_ONE;
                $bookedSeatsCount++;
            }
            $bookedSeats = "Your ticket is booked with seat no: " . implode(",", $seatsNo);
        }

        return response(['msg' => $bookedSeats], 200);
    }
}

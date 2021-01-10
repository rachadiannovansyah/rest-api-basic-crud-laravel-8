<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;

class ReservationController extends Controller
{
    public function getAll() {
        $reservations = auth()->user()->reservations;

        return response()->json([
            'success' => true,
            'message' => 'data was found!',
            'data' => $reservations
        ]);
    }

    public function getById($id) {
        $reservation = auth()->user()->reservations()->find($id);

        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'data with id ' . $id . ' not found!',
                'data' => null
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'data was found!',
            'data' => $reservation->toArray()
        ], 200);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'judul_reservation' => 'required',
            'duration' => 'required|integer',
            'status' => 'required|in:available, not available'
        ]);

        $reservation = new Reservation();
        $reservation->judul_reservation = $request->judul_reservation;
        $reservation->duration = $request->duration;
        $reservation->status = $request->status;
        
        if (auth()->user()->reservations()->save($reservation)) {
            return response()->json([
                'success' => true,
                'message' => 'data has been successfully added!',
                'data' => $reservation
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'add data is denied!',
                'data' => null
            ], 500);
        }
    }

    public function update(Request $request, $id) {
        $reservation = auth()->user()->reservations()->find($id);

        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'data with id ' . $id . ' not found!',
                'data' => null
            ], 400);
        }

        $updateReservation = $reservation->fill($request->all())->save();

        if ($updateReservation) {
            return response()->json([
                'success' => true,
                'message' => 'data has been successfully updated!',
                'data' => $reservation
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data is could not be updated!',
                'data' => null
            ], 500);
        }
    }

    public function destroy($id) {
        $reservation = auth()->user()->reservations()->find($id);

        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'data with id ' . $id . ' not found!',
                'data' => null
            ], 400);
        }

        $deleteReservation = $reservation->delete();

        return response()->json([
            'success' => true,
            'message' => 'data has been successfully deleted!',
            'data' => null
        ], 200);
    }
}

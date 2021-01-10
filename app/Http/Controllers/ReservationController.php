<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;

class ReservationController extends Controller
{
    /**
     * Function to provided respond payload
     * @author by SedekahCode
     * @since Januari 2021
     * @param trueOrFalse bool
     * @param message string
     * @param data object
     * @return JSON
     */
    private function respondPayload($trueOrFalse, $message, $data) {
        $res = response([
            'success' => $trueOrFalse,
            'message' => $message,
            'data' => $data
        ],
        $trueOrFalse === true ? 201 : 500);

        return $res;
    }

    /**
     * Function to get all data
     * @author by SedekahCode
     * @since Januari 2021
     * @return JSON
     */
    public function getAll() {
        $reservations = auth()->user()->reservations;

        return $this->respondPayload(true, 'data was found!', $reservations);
    }

    /**
     * Function to get data by id
     * @author by SedekahCode
     * @since Januari 2021
     * @param id integer
     * @return JSON
     */
    public function getById($id) {
        $reservation = auth()->user()->reservations()->find($id);

        if (!$reservation) {
            return $this->respondPayload(false, 'data with id '.$id.' not found!', null);
        }

        return $this->respondPayload(true, 'data was found!', $reservation);
    }

    /**
     * Function to store data
     * @author by SedekahCode
     * @since Januari 2021
     * @param Request object
     * @return JSON
     */
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
            return $this->respondPayload(true, 'data has been successfully added!', $reservation);
        } else {
            return $this->respondPayload(false, 'add data is denied!', null);
        }
    }

    /**
     * Function to update data exist
     * @author by SedekahCode
     * @since Januari 2021
     * @param Request object
     * @param id integer
     * @return JSON
     */
    public function update(Request $request, $id) {
        $reservation = auth()->user()->reservations()->find($id);

        if (!$reservation) {
            return $this->respondPayload(false, 'data with id '.$id.' not found!', null);
        }

        $updateReservation = $reservation->fill($request->all())->save();

        if ($updateReservation) {
            return $this->respondPayload(true, 'data has been successfully updated!', $reservation);
        } else {
            return $this->respondPayload(false, 'data is could not be updated!', null);
        }
    }

    /**
     * Function to delete data by id
     * @author by SedekahCode
     * @since Januari 2021
     * @param id integer
     * @return JSON
     */
    public function destroy($id) {
        $reservation = auth()->user()->reservations()->find($id);

        if (!$reservation) {
            return $this->respondPayload(false, 'data with id '.$id.' not found!', null);
        }

        $deleteReservation = $reservation->delete();

        return $this->respondPayload(true, 'data has been successfully deleted!', null);
    }
}

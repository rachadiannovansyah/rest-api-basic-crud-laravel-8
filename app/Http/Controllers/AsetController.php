<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;

class AsetController extends Controller
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
        $result = Aset::all();

        return $this->respondPayload(true, 'data was found!', $result);
    }

    /**
     * Function to get data by id
     * @author by SedekahCode
     * @since Januari 2021
     * @return JSON
     */
    public function getById($id) {
        // check exists aset
        $checkExists = Aset::firstWhere('aset_id', $id);
        if (!$checkExists) { return $this->respondPayload(false, 'data not found!', null); }

        return $this->respondPayload(true, 'data was found!', $checkExists);
    }

    /**
     * Function to get data by id
     * @author by SedekahCode
     * @since Januari 2021
     * @param id integer
     * @return JSON
     */
    public function store(Request $request) {
        $newAset = new Aset();
        $newAset->aset_id = $request->aset_id;
        $newAset->nama_aset = $request->nama_aset;
        $newAset->category = $request->category;
        $newAset->status = $request->status;
        $newAset->description = $request->description;
        $newAset->save();
        
        return $this->respondPayload(true, 'data has been successfully added', $newAset);
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
        // check exists aset
        $checkExists = Aset::firstWhere('aset_id', $id);

        if ($checkExists) {
            $getAset = Aset::find($id);
            $getAset->aset_id = $getAset->aset_id;
            $getAset->nama_aset = $request->nama_aset ? $request->nama_aset : $getAset->nama_aset;
            $getAset->category = $request->category ? $request->category : $getAset->category;
            $getAset->status = $request->status ? $request->status : $getAset->status;
            $getAset->description = $request->description ? $request->description : $getAset->description;
            $getAset->save();
    
            return $this->respondPayload(true, 'data has been successfully updated!', $getAset);
        } else {
            return $this->respondPayload(false, 'data is not found!');
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
        // check exists aset
        $checkExists = Aset::firstWhere('aset_id', $id);
        if ($checkExists) {
            Aset::destroy($id);
            return $this->respondPayload(true, 'data has been successfully deleted!', null);
        } else {           
            return $this->respondPayload(false, 'data not found!', null);
        }
    }
}

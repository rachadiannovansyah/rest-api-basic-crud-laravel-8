<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;

class AsetController extends Controller
{
    /**
     * Function to provided payload success
     * @author by SedekahCode
     * @since Januari 2021
     * @request message string
     * @request $data object
     */
    private function resSuccess($message, $data) {
        $res = response([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], 201);

        return $res;
    }

    /**
     * Function to provided payload failed
     * @author by SedekahCode
     * @since Januari 2021
     * @request message string
     * @request $data object
     */
    private function resFailed($message){
        $res = response([
            'success' => false,
            'message' => $message,
            'data' => null
        ], 404);

        return $res;
    }

    /**
     * Function to get all data
     * @author by SedekahCode
     * @since Januari 2021
     */
    public function getAll() {
        $result = Aset::all();

        return response()->json($result, 200);
    }

    /**
     * Function to get data by id
     * @author by SedekahCode
     * @since Januari 2021
     */
    public function getById($id) {
        // check exists aset
        $checkExists = Aset::firstWhere('aset_id', $id);
        if (!$checkExists) { return $this->resFailed('Aset is not found', null); }

        return $this->resSuccess('Aset was found!', $checkExists);
    }

    /**
     * Function to save new data
     * @author by SedekahCode
     * @since Januari 2021
     * @request request object
     */
    public function store(Request $request) {
        $newAset = new Aset();
        $newAset->aset_id = $request->aset_id;
        $newAset->nama_aset = $request->nama_aset;
        $newAset->category = $request->category;
        $newAset->status = $request->status;
        $newAset->description = $request->description;
        $newAset->save();
        
        return $this->resSuccess('Aset has been successfully saved', $newAset);
    }

    /**
     * Function to update existing data
     * @author by SedekahCode
     * @since Januari 2021
     * @request request object
     * @request id string
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
    
            return $this->resSuccess('Aset has been successfully updated', $getAset);
        } else {
            return $this->resFailed('Aset is not exists');
        }
    }

     /**
     * Function to delete data
     * @author by SedekahCode
     * @since Januari 2021
     * @request id string
     */
    public function destroy($id) {
        // check exists aset
        $checkExists = Aset::firstWhere('aset_id', $id);
        if ($checkExists) {
            Aset::destroy($id);
            return $this->resSuccess('Aset has been successfully deleted', null);
        } else {           
            return $this->resFailed('Aset is not exists');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreVesselsRequest;
use App\Http\Requests\UpdateVesselsRequest;
use App\Models\Vessels;
use App\Http\Middleware\SanitizeMiddleware;

class VesselsController extends Controller
{
    /**
     * Retrieve vessels list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVesselList()
    {

      //Get vessels list
      //paginate method allow user to load 20 record at each time
      // user can change page like that http://127.0.0.1:8000/api/get-vessel-list?page=2
      $vesselsList = Vessels::paginate(20);

      return $this->__response(200, 'success', $vesselsList);

    }

    /**
     * Create new Vessel.
     *
     * @return \Illuminate\Http\Response
     */
    public function createVessel(Request $request)
    {

      //Add required on all parameters
      $request->validate(['name' => 'required']);
      $request->validate(['ownerid' => 'required']);
      $request->validate(['naccscode' => 'required']);

      //Check if Vessels NACCS code already exist
      $vesselsList = Vessels::where('naccscode', $request->naccscode)
      ->get();

      //Check if there Vessel already saved with the same code
      if($vesselsList->count() == 0){

          //create new instance of Vessels model
          $vessel = new Vessels();

          //Match fields from request to model
          $vessel->fill($request->all());
          //Save vessel
          $vessel->save();

          return $this->__response(200, "success, vessel created", $vessel);


      }else{
          return $this->__response(200, "Sorry this naccscode is already used", null);
      }


    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVesselsRequest  $request
     * @param  \App\Models\Vessels  $vessels
     * @return \Illuminate\Http\Response
     */
    public function updateVessel(Request $request)
    {

      //Add required on id parameter
      // name, ownerid and naccscode are not required
      $request->validate(['vessel_id' => 'required']);

      //Find Vessel by id
      $vessel = Vessels::where('id', $request->vessel_id)->first();

      //Check if Vessel exist
      if ($vessel != null) {
        //Vessel exist

        //Check if user whant to update name (check if name exist)
        if ($request->has("name")) {
          $vessel->name = $request->name;
        }

        //Check if user whant to update ownerid (check if ownerid exist)
        if ($request->has("ownerid")) {
          $vessel->ownerid = $request->ownerid;
        }

        //Check if user whant to update naccscode (check if naccscode exist)
        if ($request->has("naccscode")) {
          $vessel->naccscode = $request->naccscode;

          //Check if Vessels NACCS code already exist
          $vesselsList = Vessels::where('naccscode', $request->naccscode)
          ->get();

          //Check if there Vessel already saved with the same code
          if($vesselsList->count() != 0){
              return $this->__response(200, "Sorry this naccscode is already used", null);
          }
        }

        //Save updates
        $vessel->update();

        return $this->__response(1, 'success, vessel updated', $vessel);

      } else {
        //No Vessel found
        return $this->__response(200, "Sorry no vessel found", null);
      }




    }



    private function __response($status, $message, $data)
    {
      $response = [
        'status' => $status,
        'message' =>  $message,
        'data' => $data
      ];
      return response($response, 200);
    }
}

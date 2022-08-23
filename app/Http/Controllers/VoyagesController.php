<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreVoyagesRequest;
use App\Http\Requests\UpdateVoyagesRequest;
use App\Models\Voyages;
use App\Models\Vessels;

class VoyagesController extends Controller
{

  /**
   * Retrieve Voyages list.
   *
   * @return \Illuminate\Http\Response
   */
  public function getVoyageList()
  {

    //Get Voyages list
    //paginate method allow user to load 20 record at each time
    // user can change page like that http://127.0.0.1:8000/api/get-voyage-list?page=2
    $voyagesList = Voyages::paginate(20);

    return $this->__response(200, 'success', $voyagesList);

  }

  /**
   * Create new Voyage.
   *
   * @return \Illuminate\Http\Response
   */
  public function createVoyage(Request $request)
  {

        //Add required on all parameters
        $request->validate(['vessel_id' => 'required']);
        $request->validate(['departure_city' => 'required']);
        $request->validate(['arrival_city' => 'required']);
        $request->validate(['departure_date' => 'required']);
        $request->validate(['departure_time' => 'required']);
        $request->validate(['arrival_date' => 'required']);
        $request->validate(['arrival_time' => 'required']);

        //create new instance of Voyages model
        $voyage = new Voyages();

        //Match fields from request to model
        $voyage->fill($request->all());
        //Save voyage
        $voyage->save();

        return $this->__response(200, "success, voyage created", $voyage);


  }



  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateVoyagesRequest  $request
   * @param  \App\Models\Voyages  $vessels
   * @return \Illuminate\Http\Response
   */
  public function updateVoyage(Request $request)
  {

    //Add required on id parameter
    // vessel_id, departure_city, arrival_city, departure_date
    //departure_time, arrival_date, and arrival_time are not required
    $request->validate(['voyage_id' => 'required']);

    //Find Voyage by id
    $voyage = Voyages::where('id', $request->voyage_id)->first();

    //Check if Voyage exist
    if ($voyage != null) {
      //Voyage exist

      //Check if user whant to update vessel_id (check if vessel_id exist)
      if ($request->has("vessel_id")) {
        $voyage->vessel_id = $request->vessel_id;
      }

      //Check if user whant to update departure_city (check if departure_city exist)
      if ($request->has("departure_city")) {
        $voyage->departure_city = $request->departure_city;
      }

      //Check if user whant to update arrival_city (check if arrival_city exist)
      if ($request->has("arrival_city")) {
        $voyage->arrival_city = $request->arrival_city;
      }

      //Check if user whant to update departure_date (check if departure_date exist)
      if ($request->has("departure_date")) {
        $voyage->departure_date = $request->departure_date;
      }
      //Check if user whant to update arrival_city (check if arrival_city exist)
      if ($request->has("departure_time")) {
        $voyage->departure_time = $request->departure_time;
      }

      //Check if user whant to update arrival_date (check if arrival_date exist)
      if ($request->has("arrival_date")) {
        $voyage->arrival_date = $request->arrival_date;
      }

      //Check if user whant to update arrival_time (check if arrival_time exist)
      if ($request->has("arrival_time")) {
        $voyage->arrival_time = $request->arrival_time;
      }


      //Save updates
      $voyage->update();

      return $this->__response(1, 'success, voyage updated', $voyage);

    } else {
      //No Voyage found
      return $this->__response(200, "Sorry no voyage found", null);
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

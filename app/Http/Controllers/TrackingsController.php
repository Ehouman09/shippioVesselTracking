<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreTrackingsRequest;
use App\Http\Requests\UpdateTrackingsRequest;
use App\Models\Trackings;

class TrackingsController extends Controller
{


  /**
   * Retrieve Voyages list.
   *
   * @return \Illuminate\Http\Response
   */
  public function getTrackingList()
  {

    //Get Trackings list
    //paginate method allow user to load 20 record at each time
    // user can change page like that http://127.0.0.1:8000/api/get-tracking-list?page=1
    $trackingsList = Trackings::paginate(20);

    return $this->__response(200, 'success', $trackingsList);

  }

  /**
   * Create new Tracking.
   *
   * @return \Illuminate\Http\Response
   */
  public function addTracking(Request $request)
  {

        //Add required on all parameters
        $request->validate(['voyage_id' => 'required']);
        $request->validate(['city' => 'required']);
        $request->validate(['arrival_date' => 'required']);
        $request->validate(['arrival_time' => 'required']);

        //create new instance of Trackings model
        $tracking = new Trackings();

        //Match fields from request to model
        $tracking->fill($request->all());
        //Save Tracking
        $tracking->save();

        return $this->__response(200, "success, tracking created", $tracking);


  }



  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\TrackingsRequest  $request
   * @param  \App\Models\Trackings
   * @return \Illuminate\Http\Response
   */
  public function updateTracking(Request $request)
  {

    //Add required on id parameter
    // voyage_id, city, arrival_date, arrival_time are not required
    $request->validate(['tracking_id' => 'required']);

    //Find tracking by id
    $tracking = Trackings::where('id', $request->tracking_id)->first();

    //Check if tracking exist
    if ($tracking != null) {
      //tracking exist

      //Check if user whant to update city (check if city exist)
      if ($request->has("city")) {
        $tracking->city = $request->city;
      }

      //Check if user whant to update arrival_date (check if arrival_date exist)
      if ($request->has("arrival_date")) {
        $tracking->arrival_date = $request->arrival_date;
      }

      //Check if user whant to update arrival_time (check if arrival_time exist)
      if ($request->has("arrival_time")) {
        $tracking->arrival_time = $request->arrival_time;
      }

      //Check if user whant to update voyage_id (check if voyage_id exist)
      if ($request->has("voyage_id")) {
        $tracking->voyage_id = $request->voyage_id;
      }


      //Save updates
      $tracking->update();

      return $this->__response(1, 'success, tracking updated', $tracking);

    } else {
      //No Trackings found
      return $this->__response(200, "Sorry no tracking found", null);
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

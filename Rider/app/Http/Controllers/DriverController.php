<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookRiderRequest;
use App\Models\Booking;
use App\Models\Trip;

class DriverController extends Controller
{
    // get all books
    public function index()
    {
        $input = $request->all();

        $book = $this->bookingRepository->store($input);

        return $this->successResponse($book,'Booking Successful', 201);
    }

    // accept or decline
    public function action(BookRiderRequest $request, Booking $book)
    {
        $book = $this->bookingRepository->updateStatus($request, $book);

        return $this->successResponse($book,'Booking Successful Updated', 200);
    }

    //get pending bookings
    public function pending()
    {
        $bookings = $this->bookingRepository->pending();

        return $this->successResponse($bookings,'Booking Successful Retrieved', 200);
    }

    // start trip
    public function startTrip(Trip $trip, Request $request)
    {
        $trip = $this->bookingRepository->trip($trip, $request);

        return $this->successResponse($bookings,'Trip Successful Created', 201);
    }

     //mark trip as completed
     public function updateTrip(Trip $trip, Request $request)
     {
         $trip = $this->bookingRepository->trip($trip, $request);
 
         return $this->successResponse($bookings,'Trip Successful Updated', 200);
     }


}

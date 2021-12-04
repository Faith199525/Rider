<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateBooking;
use App\Http\Requests\CompleteTripRequest;
use App\Models\Booking;
use App\Models\Trip;
use App\Repositories\DriverRepository;
use App\Http\Controllers\ApiBaseController;

class DriverController extends ApiBaseController
{
    public function __construct(DriverRepository $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

     /**
     * get all accepted booking.
     *
     */
    public function index()
    {
        $bookings = $this->driverRepository->getBookings();

        return $this->successResponse($bookings,'Bookings Successful Retrieved', 200);
    }

    public function show(Booking $booking)
    {
        return $this->successResponse($booking,'Booking Successful Retrieved', 200);
    }

    /**
     * accept or reject a booking.
     *
     */
    public function action(UpdateBooking $request, Booking $booking)
    {
        $book = $this->driverRepository->updateStatus($request, $booking);

        if($book == 'Journey on going'){
            return $this->errorResponse('Journry On going', 425);
        }

        if($book == 'Bus is full'){
            return $this->errorResponse('Bus is full', 426);
        }

        return $this->successResponse($book,'Booking Successful Updated', 200);
    }

    /**
     * retrieve pending bookings.
     *
     */
    public function pending()
    {
        $bookings = $this->driverRepository->getPending();

        return $this->successResponse($bookings,'Pending Booking Successful Retrieved', 200);
    }

    /**
     * mark trip as completed.
     *
     */
    public function markTripCompleted(Trip $trip, CompleteTripRequest $request)
    {
        $trip = $this->driverRepository->completed($trip, $request);

        return $this->successResponse($trip,'Trip Successful Completed', 200);
    }

    public function showTrip(Trip $trip)
    {
        return $this->successResponse($trip,'Trip Successful Retrieved', 200);
    }

    public function allTrips()
    {
        $trips = $this->driverRepository->getAllTrips();

        return $this->successResponse($trips,'Trip Successful Retrieved', 200);
    }

}

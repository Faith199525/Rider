<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookRiderRequest;
use App\Repositories\BookingRepository;
use App\Http\Controllers\ApiBaseController;

class BookingController extends ApiBaseController
{
    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

     /**
     * get the list of available buses.
     *
     */
    public function index()
    {
        $buses = $this->bookingRepository->getBuses();

        return $this->successResponse($buses,'Availaible Buses Retrieved Successful', 200);
    }
     /**
     * book a ride.
     *
     */
    public function book(BookRiderRequest $request)
    {
        $book = $this->bookingRepository->bookRide($request);

        if($book == 'Journey on going'){
            return $this->errorResponse('Journry On going', 425);
        }

        if($book == 'Bus is full'){
            return $this->errorResponse('Bus is full', 426);
        }

        return $this->successResponse($book,'Booking Successful, Awaiting Approval', 201);
    }

    public function myBookings()
    {
        $bookings = $this->bookingRepository->getBookings();

        return $this->successResponse($bookings,'Bookings Retrieved Successful', 200);
    }
}

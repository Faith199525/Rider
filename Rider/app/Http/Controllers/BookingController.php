<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookRiderRequest;
use App\Repositories\BookingRepository;

class BookingController extends ApiBaseController
{
    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }
    // get the list of available buses
    public function index()
    {
        $buses = $this->bookingRepository->getBuses($input);

        return $this->successResponse($buses,'Availaible Buses Retrieved Successful', 200);
    }

    //book a ride

    public function store(BookRiderRequest $request)
    {
        $input = $request->all();

        $book = $this->bookingRepository->store($input);

        //add notification system
        // $request->user()->notify(new Book());

        return $this->successResponse($book,'Booking Successful', 201);
    }
}

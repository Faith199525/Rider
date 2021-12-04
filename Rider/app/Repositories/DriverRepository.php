<?php
namespace App\Repositories;

use App\Models\Booking;
use App\Models\Trip;
use App\Models\Bus;

class DriverRepository
{

    public function updateStatus($request, $booking)
    {
        if($request->status == 'accepted'){
            $trip = Trip::find($booking->trip_id);

            switch( $trip->status ){
                    
                case 'started':
                    return 'Journey on going';
                  break;
                case 'loading': 
                    $seats = $trip->bus->seats;
                    if($trip->seats_taken == $seats){
                        $trip->status = 'started';
                        $trip->save();
                        return 'Bus is full';
                    }
                    $number = (int)$trip->seats_taken + 1;
                    if($trip->bus->seats == $number){
                        $trip->status = 'started';
                    }
                    $trip->seats_taken = $number;
                    $trip->save();
                  break;
            }
        }

        $booking->status = $request->status;
        $booking->save();

        return $booking;
    }

    public function getPending()
    {
        $pending = Booking::where('status', 'pending')
                ->whereHas('bus', function($query){
                    $query->where('driver_id', auth()->user()->id);
            })->get();

        return $pending;
    }

    public function getBookings()
    {
        $bookings = Booking::where('status', 'accepted')
                ->whereHas('bus', function($query){
                    $query->where('driver_id', auth()->user()->id);
            })->get();

        return $bookings;
    }

    public function completed($trip, $request)
    {
        $trip->status = 'completed';
        $trip->save();

        return $trip;
    }

    public function getAllTrips()
    {
        $trips = Trip::with('bookings')
                ->whereHas('bus', function($query){
                $query->where('driver_id', auth()->user()->id);
                })->get();

        return $trips;
    }

}



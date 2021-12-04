<?php
namespace App\Repositories;

use App\Models\Booking;
use App\Models\Trip;
use App\Models\Bus;

class BookingRepository
{

    public function bookRide($request)
    {
        $bus = Bus::find($request->bus_id);

        if(count($bus->trips) > 0){
            $lastTrip = Trip::where('bus_id', $request->bus_id)->latest()->first();
            switch( $lastTrip->status ){
                    
                case 'started':
                    return 'Journey on going';
                  break;
                case 'completed': 
                    $newTrip = Trip::create([
                        'seats_taken' => 0,
                        'status' => 'loading',
                        'bus_id' => $request->bus_id
                    ]);
                    $request->merge(['trip_id' => $newTrip->id]); 
                  break;
                case 'loading': 
                    $seats = $bus->seats;
                    if($lastTrip->seats_taken == $seats){
                        // $lastTrip->status = 'started';
                        // $lastTrip->save();
                        return 'Bus is full';
                    }
                    // $lastTrip->seats_taken = (int)$lastTrip->seats_taken + 1;
                    // $lastTrip->save();
                    $request->merge(['trip_id' => $lastTrip->id]); 
                  break;
            }
        }else{

            $newTrip = Trip::create([
                'seats_taken' => 0,
                'status' => 'loading',
                'bus_id' => $request->bus_id
            ]);
            $request->merge(['trip_id' => $newTrip->id]); 
        }

        $input = $request->all();

        $book = Booking::create($input);

        return $book;
    }

    public function getBuses()
    {
         $buses = Bus::wheredoesntHave('trips', function($q){
            $q->where('status', 'started');
            })->get();

        return $buses;
    }

    public function getBookings()
    {
        $bookings = Booking::where('rider_id', auth()->user()->id)->get();
        $bookings->map(function ($booking, $key) {
            $trip = Trip::find($booking->trip_id);
            $booking->trip = $trip;
        });

        return $bookings;
    }

}



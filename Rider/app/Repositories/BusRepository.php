<?php
namespace App\Repositories;

use App\Models\Bus;

class BusRepository
{

    public function register($request)
    {
        $request->merge(['driver_id' => auth()->user()->id]); 
        $input = $request->all();

        $bus = Bus::create($input);

        return $bus;
    }

    public function update($bus, $request)
    {
         $bus->serial_no = $request->serial_no;
         $bus->seats = $request->seats;
         $bus->plate_no = $request->plate_no;
         $bus->save();

        return $bus;
    }

}



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterBusRequest;
use App\Repositories\BusRepository;
use App\Models\Bus;
use App\Http\Controllers\ApiBaseController;

class BusController extends ApiBaseController
{
    public function __construct(BusRepository $busRepository)
    {
        $this->busRepository = $busRepository;
    }
    /**
     * get the list of all my buses.
     *
     */
    public function myBuses()
    {
        $buses = auth()->user()->driver->buses;

        return $this->successResponse($buses,'Availaible Buses Retrieved Successful', 200);
    }
     /**
     * register a bus.
     *
     */
    public function store(RegisterBusRequest $request)
    {
        $bus = $this->busRepository->register($request);

        return $this->successResponse($bus,'Bus Registered Successfully', 200);
    }

    public function show(Bus $bus)
    {
        return $this->successResponse($bus,'Bus Retrieved Successfully', 200);
    }

    public function update(Bus $bus, RegisterBusRequest $request)
    {
        $bus = $this->busRepository->update($bus, $request);

        return $this->successResponse($bus,'Bus Updated Successfully', 200);
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();

        return $this->successResponse($bus,'Bus Deleted Successfully', 200);
    }
}

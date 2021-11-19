<?php

namespace App\Http\Controllers;


class ApiBaseController extends Controller
{
    public function errorResponse($message = null, $code = 404)
    {
        return response()->json([
          'status'=>'Error',
          'message' => $message
        ], $code);
    }

    public function successResponse($data = [], $message = null, $code = 200)
    {
        return response()->json([
          'status'=> 'Success', 
          'message' => $message, 
          'data' => $data
        ], $code);
    }
}

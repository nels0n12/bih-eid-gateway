<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser
{
    /**
     * Build success response
     * @param  string|array $data
     * @param  int $code
     */
    public function successResponse($data, $code = Response::HTTP_OK)
    {
        return response($data, $code)->header('Content-Type', 'application/json');
    }

    /**
     * Build valid response
     * @param  string|array $data
     * @param  int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function validResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json(['data' => $data], $code);

    }

    /**
     * Build error responses
     * @param  string|array $message
     * @param  int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $code)
    {

        return response()->json([
            'type' => 'error',
            'nature' => 'message',
            'datatype' => gettype($message),
            'data' => $message,
            'code' => $code,
            'from'=>env('APP_NAME')
        ],
            $code
        );
    }

    /**
     * Build error responses
     * @param  string|array $message
     * @param  int $code
     * @return \Illuminate\Http\Response
     */
    public function errorMessage($message, $code)
    {
        return response($message, $code)->header('Content-Type', 'application/json');
    }
}

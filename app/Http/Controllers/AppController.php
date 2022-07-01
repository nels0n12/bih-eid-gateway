<?php

namespace App\Http\Controllers;

use App\Services\AppService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class AppController extends Controller
{

    use ApiResponser;


    /**
     * The service to consume notes microservice
     * @var AppService
     */
    public $appService;


    /**
     * The base uri to consume the authors service
     * @var int
     */
    public $user;

    public function __construct(AppService $appService)
    {
//        $this->user = auth()->user()->id;
        $this->appService = $appService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateOmang(Request $request)
    {
        $data = json_decode($this->appService->validate($request->omang));
        if ($data->status === 'success') {
            return response()->json([
                "status" => "success",
                "message" => "omang found",
                "data" => $data->data
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "omang not found",
                "data" => ''
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyOmang(Request $request)
    {
        $data = (bool)$this->appService->verify($request->omang);
        if ($data === true) {
            $data = json_decode($this->appService->validate($request->omang));

            if ($request->tier === 'tier1') {
                return response()->json([
                    "status" => "success",
                    "message" => "omang found",
                    "data" => rand(111111,999999)
                ]);
            } elseif ($request->tier === 'tier2') {
                return response()->json([

                    "status" => "success",
                    "message" => "omang found",
                    "data" => [
                        [
                            "question" => 'BIRTH_DTE',
                            "answer" => $data->data->BIRTH_DTE
                        ],
                        [
                            "question" => 'BIRTH_PLACE_NME',
                            "answer" => $data->data->BIRTH_PLACE_NME
                        ],
                        [
                            "question" => 'OCCUPATION_CDE',
                            "answer" => $data->data->OCCUPATION_CDE
                        ]
                    ]
                ]);
            } else {
                return response()->json([

                    "status" => "success",
                    "message" => "omang found",
                    "data" => rand(111111,999999)
                ]);
            }
        } else {
            return response()->json([
                "status" => "error",
                "message" => "omang not found",
                "data" => ''
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Responses\ApiResponse;
use Illuminate\Http\Request;

class AuthCheckController extends Controller
{
    /**
     * @var ApiResponse
     */
    private $apiResponse;


    /**
     * AuthCheckController constructor.
     * @param ApiResponse $apiResponse
     */
    public function __construct(ApiResponse $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }

    public function authCheck()
    {
        if(auth()->check()) {
            return $this->apiResponse->success(true);
        }else{
            return $this->apiResponse->success(false);
        }
    }
}

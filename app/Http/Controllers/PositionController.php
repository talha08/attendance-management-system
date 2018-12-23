<?php

namespace App\Http\Controllers;

use App\Responses\ApiResponse;
use App\Services\PositionService;
use App\Transformers\Api\DropdownTransformer;
use App\Transformers\Api\PositionTransformer;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * @var PositionService
     */
    private $positionService;
    /**
     * @var ApiResponse
     */
    private $apiResponse;


    /**
     * PositionController constructor.
     * @param PositionService $positionService
     */
    public function __construct(PositionService $positionService, ApiResponse $apiResponse)
    {
        $this->positionService = $positionService;
        $this->apiResponse = $apiResponse;
    }


    public function getPositionDropdown()
    {
        try{
            $positions = $this->positionService->getPositionDropdown();
            return $this->apiResponse->withCollection($positions, new DropdownTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }


    public function getAllPositions()
    {
        try{
            $positions = $this->positionService->getAllPositions();
            return $this->apiResponse->withPaginator($positions, new PositionTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }


    public function createNewPosition(Request $request)
    {
        try{
            $positions = $this->positionService->createNewPosition($request);
            return $this->apiResponse->withItem($positions, new PositionTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }

    public function updatePosition(Request $request, $id)
    {
        try{
            $positions = $this->positionService->updatePosition($request, $id);
            return $this->apiResponse->withItem($positions, new PositionTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }


    public function deletePosition($id)
    {
        try{
            $positions = $this->positionService->delete($id);
            return $this->apiResponse->success('Deleted Successfully');
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }
}

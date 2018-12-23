<?php

namespace App\Http\Controllers\Auth;

use App\Responses\ApiResponse;
use App\Services\UserService;
use App\Transformers\Api\DropdownTransformer;
use App\Transformers\Api\UserTransformer;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * @var ApiResponse
     */
    private $apiResponse;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     * @param ApiResponse $apiResponse
     */
    public function __construct(ApiResponse $apiResponse, UserService $userService)
    {
        $this->apiResponse = $apiResponse;
        $this->userService = $userService;
    }

    public function getUser()
    {
        $user = auth()->user();
        return  $this->apiResponse->withItem($user, new UserTransformer());
    }


    public function getAllUserDropdown()
    {
        try{
            $users = $this->userService->getAllUserDropdown();
            return $this->apiResponse->withCollection($users, new DropdownTransformer());
        }catch (\Exception $ex){
            return $this->apiResponse->errorForbidden($ex->getMessage());
        }
    }


    public function getAllUsers()
    {
        try{
            $users = $this->userService->getAllUsers();
            return  $this->apiResponse->withPaginator($users, new UserTransformer());
        }catch (\Exception $ex){
            return $this->apiResponse->errorForbidden($ex->getMessage());
        }
    }


    public function createNewUser(Request $request)
    {
        try{
            DB::beginTransaction();
            $user = $this->userService->createNewUser($request);
            DB::commit();
            return  $this->apiResponse->withItem($user, new UserTransformer());
        }catch (\Exception $ex){
            DB::rollBack();
            return $this->apiResponse->errorForbidden($ex->getMessage());
        }
    }


    public function updateUser(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $user = $this->userService->updateUser($request, $id);
            DB::commit();
            return  $this->apiResponse->withItem($user, new UserTransformer());
        }catch (\Exception $ex){
            DB::rollBack();
            return $this->apiResponse->errorForbidden($ex->getMessage());
        }
    }


    public function deleteUser($id)
    {
        try{
            $user = $this->userService->delete($id);
            return  $this->apiResponse->withItem($user, new UserTransformer());
        }catch (\Exception $ex){
            return $this->apiResponse->errorForbidden($ex->getMessage());
        }
    }
}

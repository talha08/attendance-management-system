<?php

namespace App\Http\Controllers\Role;

use App\Services\RoleService;
use App\Transformers\Api\DropdownTransformer;
use App\Transformers\Api\RoleTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Responses\ApiResponse;

class RoleController extends Controller
{
    /**
     * @var ApiResponse
     */
    private $apiResponse;
    /**
     * @var RoleService
     */
    private $roleService;

    /**
     * UserController constructor.
     * @param ApiResponse $apiResponse
     * @param RoleService $roleService
     */
    public function __construct(ApiResponse $apiResponse, RoleService $roleService)
    {
        $this->apiResponse = $apiResponse;
        $this->roleService = $roleService;
    }


    public function getALlRoles()
    {
        try{
            $roles = $this->roleService->all();
            return $this->apiResponse->withCollection($roles, new RoleTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }



    public function getRolesDropdown()
    {
        try{
            $roles = $this->roleService->getRolesDropdown();
            return $this->apiResponse->withCollection($roles, new DropdownTransformer());
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }


    public function userRoleUpdate(Request $request)
    {
        try{
            $roles = $this->roleService->userRoleUpdate($request);
            return $this->apiResponse->success('Role Update Successfully');
        }catch (\Exception $exception){
            return $this->apiResponse->errorForbidden($exception->getMessage());
        }
    }
}

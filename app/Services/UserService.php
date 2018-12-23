<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 8/11/18
 * Time: 6:14 PM
 */

namespace App\Services;


use App\BaseSettings\AppSettings;
use App\Repositories\RoleRepository;
use App\Repositories\RoleUserRepository;
use App\Repositories\UserInfoRepository;
use App\Repositories\UserRepository;
use App\Responses\ApiResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class UserService extends BaseService
{
    /**
     * @var ApiResponse
     */
    private $apiResponse;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserInfoRepository
     */
    private $userInfoRepository;
    /**
     * @var RoleUserRepository
     */
    private $roleUserRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var BaseSalaryService
     */
    private $baseSalaryService;

    /**
     * UserService constructor.
     * @param ApiResponse $apiResponse
     * @param UserRepository $userRepository
     * @param UserInfoRepository $userInfoRepository
     * @param RoleUserRepository $roleUserRepository
     * @param RoleRepository $roleRepository
     * @param BaseSalaryService $baseSalaryService
     */
    public function __construct(ApiResponse $apiResponse, UserRepository $userRepository, UserInfoRepository $userInfoRepository, RoleUserRepository $roleUserRepository, RoleRepository $roleRepository, BaseSalaryService $baseSalaryService)
    {
        $this->apiResponse = $apiResponse;
        $this->userRepository = $userRepository;
        $this->userInfoRepository = $userInfoRepository;
        $this->roleUserRepository = $roleUserRepository;
        $this->roleRepository = $roleRepository;
        $this->baseSalaryService = $baseSalaryService;
    }


    /**
     * return Repository instance
     *
     * @return mixed
     */
    public function baseRepository()
    {
       return $this->userRepository;
    }


    public function getAllUsers()
    {
       return $this->userRepository->getQuery('userInfo')->paginate(AppSettings::$paginate);
    }

    public function getAllUserDropdown()
    {
        return $this->userRepository->getQuery()
            ->select('id as value', 'name as label')
            ->get();
    }


    public function createNewUser($request)
    {
        $data = $request->only('name', 'email');
        $data['password'] = bcrypt('infancyit');
        $user = $this->userRepository->create($data);

        $userInfo = $request->only('position_id','phone');
        $userInfo['user_id'] = $user->id;
        $this->userInfoRepository->create($userInfo);

        $salaryData = [
            'user_id' => $user->id,
            'salary' => $request->base_salary,
            'start_date' => Carbon::now()
        ];
        $this->baseSalaryService->create($salaryData);

        $role = $this->roleRepository->getQuery()->where('name', $request->role)->first();
        $this->roleUserRepository->create(['user_id'=> $user->id, 'role_id' => $role->id]);

        return $user;
    }


    public function updateUser($request, $id)
    {
        $data = $request->only('name', 'email');
        $user = $this->userRepository->update($data,$id);

        $userInfo = $request->only('position_id','phone');
        $this->userInfoRepository->update($userInfo, $id);

        if($request->role){
            $role = $this->roleRepository->getQuery()->where('name', $request->role)->first();
            $this->roleUserRepository->userRoleUpdate($user->id, $role->id);
        }
        return $user;
    }
}

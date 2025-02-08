<?php

namespace App\Services\Users;

use Throwable;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Repositories\Contracts\User\UserRepositoryInterface;

class UserService extends Service implements UserServiceInterface
{
    protected $userRepository;

    function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        try {
            $params = $request->all();
            $user = $request->user();
            $role = $request->user()->role->name;

            $response = $this->userRepository->index($params, $user, $role);

            return $response;
        } catch (Throwable $e) {
            return $e;
        }
    }

    public function getById($uuid)
    {
        try {
            $response = $this->userRepository->getById($uuid);

            return $response;
        } catch (Throwable $e) {
            return $e;
        }
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();

            $data['uuid'] = Str::uuid();
            $data['company_id'] = $request->user()->company_id;
            $data['password'] = Hash::make($data['password']);
            // $data['permission_id'] = $request->user()->company_id;
            // $data['role_id'] = $request->user()->company_id;
            // $data['gallery_id'] = $request->user()->company_id;
            // $data['employee_id'] = $request->user()->company_id;

            $response = $this->userRepository->create($data);

            return $response;
        } catch (Throwable $e) {
            return $e;
        }
    }

    public function updateUser(Request $request, $uuid)
    {
        try {
            $data = $request->all();

            $response = $this->userRepository->updateUser($data, $uuid);

            return $response;
        } catch (Throwable $e) {
            return $e;
        }
    }


    public function deleteUser($uuid)
    {
        try {
            $response = $this->userRepository->delete($uuid);

            return $response;
        } catch (Throwable $e) {
            return $e;
        }
    }

    // private function subscriptionNotFound($subscription, $companyId): void
    // {
    //     if (!$subscription) {
    //         throw new SubscriptionNotFoundException("No active subscription found for company ID {$companyId}.");
    //     }
    // }
}

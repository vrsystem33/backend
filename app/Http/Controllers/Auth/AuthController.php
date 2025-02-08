<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;

use App\Http\Requests\Auth\AuthRequest;
use App\Services\Auth\AuthServiceInterface;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function login(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password', 'username');

        try {
            $response = $this->authService->login($credentials);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function getAuthenticated()
    {
        try {
            $response = $this->authService->getAuthenticated();

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }


    public function logout(Request $request)
    {
        try {
            $response = $this->authService->logout($request);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }
}

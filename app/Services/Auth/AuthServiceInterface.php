<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;

interface AuthServiceInterface
{

    public function login($credentials);

    public function getAuthenticated();

    public function changePassword(Request $request);

    public function logout(Request $request);

    public function passwordRecovery(Request $request);

    public function resetPassword(Request $request);

}

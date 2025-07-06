<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Traits\ValidationTrait;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

// Models
use App\Models\Users\User;


class AuthService implements AuthServiceInterface
{
    use ValidationTrait;

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    private function setUser($user)
    {
        $this->user = $user;
    }

    public function login($credentials)
    {

        if (!auth()->attempt($credentials)) return [
            'message' => 'Usuário ou senha invalido!',
            'code' => 401,
            'error' => true
        ];

        $this->setUser(auth()->user());

        $user = $this->getUser();

        $role = $user->role()->first()->name;

        $token = $user->createToken(env('APP_TOKEN'), [$role])->accessToken;

        return [
            'token' => $token
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return [
            'message' => 'Desconectado com sucesso',
            'code' => 200,
            'error' => false
        ];
    }

    public function getAuthenticated()
    {
        $this->setUser(auth()->user());

        $user = $this->getUser();

        $check = $this->checkData($user, 'Usuário não encontrado!');

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        $roleName = $user->role->name;

        // Remove a propriedade role que é um objeto de App\Models\Users\Role
        unset($user->role);

        $user->role = $roleName;

        return $user;
    }

    public function changePassword(Request $request)
    {
        $params = $request->all();
        $id = auth()->user()->id;

        $user = User::where('id', $id)->first();

        $check = $this->checkData($user, 'Usuário não identificado!');

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        $user->update(['password' =>  Hash::make($params['password'])]);
        $user->save();

        return response()->json('Senha Atualizada', 201);
    }

    public function passwordRecovery(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __($status)], 200);
        }

        return $status === Password::RESET_LINK_SENT
            ? ['message' => __($status)]
            : ['message' => __($status), 'error' => true, 'code' => 400];
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? ['message' => __($status)]
            : ['message' => __($status), 'error' => true, 'code' => 400];
    }
}

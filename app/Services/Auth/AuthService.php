<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Traits\ValidationTrait;

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
}

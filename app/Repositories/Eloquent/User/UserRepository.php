<?php

namespace App\Repositories\Eloquent\User;

use Illuminate\Http\Request;

use App\Repositories\Contracts\User\UserRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

use App\Models\Users\User;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    protected $model = User::class;

    public function index(array $params, User $user, string $role)
    {
        $query = $this->model->with('permission', 'company')->orderBy('name', 'asc');

        if ($role != 'super') {
            $query = $this->model->where('company_id', $user->company_id);
        }

        if (isset($params['term']) && !empty($params['term'])) {
            $query->where(function ($query1) use ($params) {
                $query1->orWhere('name', 'like', '%' . $params['term'] . '%')
                    ->orWhere('email', 'like', '%' . $params['term'] . '%');
            });
        }

        if (isset($params['status']) && !empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        if (isset($params['per_page'])) {
            $result = $query->paginate($params['per_page']);
        } else {
            $result = $query->get();
        }

        return $result;
    }

    public function getById($id)
    {
        $data = $this->show($id);

        $check = $this->checkData($data, 'Usuário não encontrada!');

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        $data->role = $data->role()->first();

        return $data;
    }

    public function create(array $data)
    {
        $user = $this->store($data);

        if (!$user) return [
            'message' => 'Falha ao criar dados!',
            'code' => 500
        ];

        $user->role;

        return $user;
    }

    public function updateUser(array $data, $id)
    {

        $user = $this->model->findOrFail($id);

        if (empty($user)) return [
            'message' => 'Usuário não encontrado!',
            'code' => 500
        ];

        $user->fill($data);

        if (!$user->save()) {
            return [
                'message' => 'Falha ao atualizar dados!',
                'code' => 500
            ];
        }

        return $user;
    }
}

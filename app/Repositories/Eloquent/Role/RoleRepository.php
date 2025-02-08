<?php

namespace App\Repositories\Eloquent\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\Contracts\Role\RoleRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

 

// Models
use App\Models\Users\Role;

class RoleRepository extends AbstractRepository implements RoleRepositoryInterface
{
    /**
     * @var Role
     */
    protected $model = Role::class;

     

    public function index(Request $request)
    {
        $params = $request->all();

        $role = $request->user()->role->name;

        if ($role != 'super' ) {
            $resp = $this->model->where('name', '!=', 'super')->orderBy('name', 'asc');
        } else {
            $resp = $this->model->orderBy('name', 'asc');
        }

        if (isset($params['term']) && !empty($params['term'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('name', 'like', '%' . $params['term'] . '%')
                    ->orWhere('email', 'like', '%' . $params['term'] . '%')
                    ->orWhere('nickname', 'like', '%' . $params['term'] . '%')
                    ->orWhere('corporate_name', 'like', '%' . $params['term'] . '%')
                    ->orWhere('trade_name', 'like', '%' . $params['term'] . '%');
            });
        }

        if (isset($params['status']) && !empty($params['status'])) {
            $resp = $resp->where('status', $params['status']);
        }

        if (isset($params['per_page'])) {
            $resp = $resp->paginate($params['per_page']);
        } else {
            $resp = $resp->get();
        }

        return $resp;
    }

    public function getById($id)
    {
        $data = $this->show($id);

        $check = $this->checkData($data, 'Informação da função não encontrada');

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        return $data;
    }

    public function create(Request $request)
    {
        $data = $request->all();

        $data['uuid'] = Str::uuid();
        $data['company_id'] = $request->user()->company_id;

        $role = $this->store($data);

        if (!$role) return [
            'message' => 'Falha ao criar dados!',
            'code' => 500
        ];

        return $role;
    }

    public function updateRole(Request $request, $id)
    {
        $data = $request->all();

        $role = $this->model->findOrFail($id);

        $check = $this->checkData($role, 'Informação da função não encontrada');

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        $role->fill($data);

        if (!$role->save()) {
            return [
                'message' => 'Falha ao atualizar dados!',
                'code' => 500
            ];
        }

        return $role;
    }
}

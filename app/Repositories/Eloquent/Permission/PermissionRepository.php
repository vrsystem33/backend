<?php

namespace App\Repositories\Eloquent\Permission;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\Contracts\Permission\PermissionRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

use App\Models\Users\Permission;

class PermissionRepository extends AbstractRepository implements PermissionRepositoryInterface
{
    /**
     * @var Permission
     */
    protected $model = Permission::class;

    public function index(Request $request)
    {
        $params = $request->all();

        $resp = $this->model->where('company_id', $request->user()->company_id)->orderBy('name', 'asc');

        if (isset($params['term']) && !empty($params['term'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('name', 'like', '%' . $params['term'] . '%')
                    ->orWhere('description', 'like', '%' . $params['term'] . '%');
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

        $check = $this->checkData($data, 'Permissão não encontrada!');

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

        $permission = $this->store($data);

        if (!$permission) return [
            'message' => 'Falha ao criar dados!',
            'code' => 500
        ];

        return $permission;
    }

    public function updatePermission(Request $request, $id)
    {
        $data = $request->all();

        $permission = $this->model->findOrFail($id);

        if (empty($permission)) return [
            'message' => 'Permissão não encontrado!',
            'code' => 500
        ];

        $permission->fill($data);

        if (!$permission->save()) {
            return [
                'message' => 'Falha ao atualizar dados!',
                'code' => 500
            ];
        }

        return $permission;
    }
}

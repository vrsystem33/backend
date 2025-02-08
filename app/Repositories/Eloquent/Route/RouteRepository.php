<?php

namespace App\Repositories\Eloquent\Route;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\Contracts\Route\RouteRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

 

use App\Models\Route;

class RouteRepository extends AbstractRepository implements RouteRepositoryInterface
{
    /**
     * @var Route
     */
    protected $model = Route::class;

     

    public function index(Request $request)
    {
        $params = $request->all();

        $resp = $this->model->orderBy('id', 'asc');

        if (isset($params['term']) && !empty($params['term'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('url', 'like', '%' . $params['term'] . '%')
                    ->orWhere('controller', 'like', '%' . $params['term'] . '%')
                    ->orWhere('action', 'like', '%' . $params['term'] . '%')
                    ->orWhere('group', 'like', '%' . $params['term'] . '%');
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

        $check = $this->checkData($data, 'Rota não encontrada!');

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

        $route = $this->store($data);

        if (!$route) return [
            'message' => 'Falha ao criar dados!',
            'code' => 500
        ];

        return $route;
    }

    public function updateRoute(Request $request, $id)
    {
        $data = $request->all();

        $route = $this->model->findOrFail($id);

        if (empty($route)) return [
            'message' => 'Informação pessoal não encontrado!',
            'code' => 500
        ];

        $route->fill($data);

        if (!$route->save()) {
            return [
                'message' => 'Falha ao atualizar dados!',
                'code' => 500
            ];
        }

        return $route;
    }
}

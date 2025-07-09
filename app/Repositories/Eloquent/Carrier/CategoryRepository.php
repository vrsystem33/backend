<?php

namespace App\Repositories\Eloquent\Carrier;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\Contracts\Carrier\CategoryRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

use App\Models\Carriers\Category;

class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{
    protected $model = Category::class;

    public function index(Request $request)
    {
        $params = $request->all();
        $role = $request->user()->role->name;

        $query = $this->model->query();

        if ($role != 'super') {
            $query->where('company_id', $request->user()->company_id);
        }

        if (!empty($params['term'] ?? null)) {
            $query->where('name', 'like', '%' . $params['term'] . '%');
        }

        if (!empty($params['status'] ?? null)) {
            $query->where('status', $params['status']);
        }

        return isset($params['per_page']) ?
            $query->paginate($params['per_page']) :
            $query->get();
    }

    public function getById($uuid)
    {
        $data = $this->show($uuid);

        $check = $this->checkData($data, 'Categoria não encontrada!');
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

        $category = $this->store($data);

        if (!$category) {
            return [
                'message' => 'Falha ao criar dados!',
                'code' => 500,
            ];
        }

        return $category;
    }

    public function updateCategory(Request $request, $uuid)
    {
        $data = $request->all();
        return $this->update($data, $uuid, 'Categoria não encontrada!');
    }
}

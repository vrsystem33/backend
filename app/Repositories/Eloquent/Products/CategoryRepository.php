<?php

namespace App\Repositories\Eloquent\Products;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\Contracts\Products\CategoryRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

use App\Models\Products\ProductCategory;

class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{
    /**
     * @var ProductCategory
     */
    protected $model = ProductCategory::class;

    public function index(Request $request)
    {
        $params = $request->all();
        $role = $request->user()->role->name;

        $query = $this->model->query();

        if ($role != 'super') {
            $query->where('company_id', $request->user()->company_id);
        }

        if (isset($params['term']) && !empty($params['term'])) {
            $query->where('name', 'like', '%' . $params['term'] . '%');
        }

        if (isset($params['status']) && !empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        return isset($params['per_page']) ?
            $query->paginate($params['per_page']) :
            $query->get();
    }

    public function getById($uuid)
    {
        $data = $this->show($uuid);

        $check = $this->checkData($data, 'Categoria n\u00e3o encontrada!');
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
                'code'    => 500,
            ];
        }

        return $category;
    }

    public function updateCategory(Request $request, $uuid)
    {
        $data = $request->all();

        return $this->update($data, $uuid, 'Categoria n\u00e3o encontrada!');
    }
}

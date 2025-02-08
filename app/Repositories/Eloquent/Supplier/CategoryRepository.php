<?php

namespace App\Repositories\Eloquent\Supplier;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\Contracts\Supplier\CategoryRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

// Models
use App\Models\Supplier\Category;

class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{
    /**
     * @var Category
     */
    protected $model = Category::class;

    public function index(Request $request)
    {
        $params = $request->all();
        $role = $request->user()->role->name;

        $query = $this->model->query();

        if ($role != 'super') {
            $query->where('company_id', $request->user()->company_id);
        }

        if (isset($params['term']) && !empty($params['term'])) {
            $query->where(function ($query) use ($params) {
                $query->orWhere('name', 'like', '%' . $params['term'] . '%');
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

    public function getById($uuid)
    {
        $data = $this->show($uuid);

        $check = $this->checkData($data, 'Categoroia não encontrada!');

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

        $category = $this->store($data);

        if (!$category) return [
            'message' => 'Falha ao criar dados!',
            'code' => 500
        ];

        return $category;
    }

    public function updateCategory(Request $request, $uuid)
    {
        $data = $request->all();

        return $this->update($data, $uuid, 'Categoroia não encontrada!');
    }
}

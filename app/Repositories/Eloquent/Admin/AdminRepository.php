<?php

namespace App\Repositories\Eloquent\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

use App\Repositories\Contracts\Admin\AdminRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

use App\Utils\Tools;

// Models
use App\Models\Companies\Company;

class AdminRepository extends AbstractRepository implements AdminRepositoryInterface
{
    /**
     * @var Company
     */
    protected $model = Company::class;

    /**
     * @var Tools
     */
    protected $tools = Tools::class;

    public function index(Request $request)
    {
        $params = $request->all();

        $resp = $this->model->with('personInfo', 'address', 'gallery');

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

    public function seed()
    {
        Artisan::call('db:seed');

        return [
            'message' => 'Seed successfully completed',
            'code' => 200,
            'error' => false
        ];
    }

    public function migrate()
    {
        Artisan::call('migrate');

        return [
            'message' => 'Migrate successfully completed',
            'code' => 200,
            'error' => false
        ];
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');

        return [
            'message' => 'Configuration is cleared',
            'code' => 200,
            'error' => false
        ];
    }

    public function create(Request $request)
    {
        $data = $request->all();

        $data['uuid'] = Str::uuid();
        $data['company_id'] = $request->user()->company_id;

        $company = $this->store($data);

        if (!$company) return [
            'message' => 'Falha ao criar dados!',
            'code' => 500
        ];

        return $company;
    }

    public function updateAdmin(Request $request, $id)
    {
        $data = $request->all();

        $company = $this->model->findOrFail($id);

        if (empty($company)) return [
            'message' => 'Permissão não encontrado!',
            'code' => 500
        ];

        if (isset($data['logo_full']) && strpos($data['logo_full'], 'data:image') !== false) {
            $pathLogo = "{$request->user()->company_id}/logos";
            $data['logo_full'] = $this->tools->parse_file($data['logo_full'], $pathLogo, $data['extension']);
        } else {
            unset($data['logo_full']);
        }

        if (isset($data['logo_min']) && strpos($data['logo_min'], 'data:image') !== false) {
            $pathLogo = "{$request->user()->company_id}/logos";
            $data['logo_min'] = $this->tools->parse_file($data['logo_min'], $pathLogo, $data['extension']);
        } else {
            unset($data['logo_min']);
        }

        $company->fill($data);

        if (!$company->save()) {
            return [
                'message' => 'Falha ao atualizar dados!',
                'code' => 500
            ];
        }

        return $company;
    }
}

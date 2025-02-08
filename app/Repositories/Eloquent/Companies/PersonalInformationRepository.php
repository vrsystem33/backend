<?php

namespace App\Repositories\Eloquent\Companies;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\Eloquent\AbstractRepository;

use App\Models\Companies\PersonalInformation;
use App\Repositories\Contracts\Companies\PersonalInformationRepositoryInterface;

class PersonalInformationRepository extends AbstractRepository implements PersonalInformationRepositoryInterface
{
    /**
     * @var PersonalInformation
     */
    protected $model = PersonalInformation::class;

    public function index(Request $request)
    {
        $params = $request->all();

        $resp = $this->model->orderBy('name', 'asc');

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

        $check = $this->checkData($data, 'Informação pessoal não encontrada!');

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

        $personInfo = $this->store($data);

        if (!$personInfo) return [
            'message' => 'Falha ao criar dados!',
            'code' => 500
        ];

        return $personInfo;
    }

    public function updatePersonInfo(array $data, $uuid)
    {
        $personInfo = $this->model->findOrFail($uuid);

        if (empty($personInfo)) return [
            'message' => 'Informação pessoal não encontrado!',
            'error' => true,
            'code' => 500
        ];

        $personInfo->fill($data);

        if (!$personInfo->save()) {
            return [
                'message' => 'Falha ao atualizar dados!',
                'code' => 500
            ];
        }

        return $personInfo;
    }
}

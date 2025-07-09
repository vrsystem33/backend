<?php

namespace App\Repositories\Eloquent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Services
use App\Services\RelationshipService;

// Utils
use App\Utils\Tools;

// Models
use App\Models\Companies\Gallery;

abstract class AbstractRepository
{
    protected $model;
    protected $tools;
    protected $relationshipService;

    public function __construct(
        RelationshipService $relationshipService
    ) {
        $this->model = $this->resolveModel();
        $this->tools = $this->resolveTools();
        $this->relationshipService = $relationshipService;
    }

    protected function resolveModel()
    {
        return app($this->model);
    }

    protected function resolveTools()
    {
        return app($this->tools);
    }

    // Use the checkData method to check if data exists
    public function checkData($data, $message)
    {
        if ($data && !empty($data)) return true;

        return [
            'message' => $message,
            'code' => 500,
            'error' => true
        ];
    }

    public function all()
    {
        return $this->model->all();
    }

    public function listing(Request $request)
    {
        return $this->model->all();
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function where($collum, $value, $operator = null)
    {
        if (!is_null($operator)) {
            return $this->model->where($collum, $operator, $value);
        }

        return $this->model->where($collum, $value);
    }

    public function store($dados)
    {
        return $this->model->create($dados);
    }

    public function createInfo(array $data, string $personModelClass, string $addressModelClass,)
    {
        $data['uuid'] = Str::uuid();

        $dataPersonAddress = $this->relationshipService->createPersoninfoAndAddress($data, $personModelClass, $addressModelClass);

        $data['personal_info_id'] = $dataPersonAddress['personal_info_id'];
        $data['address_id'] = $dataPersonAddress['address_id'];

        $returnData = $this->store($data);

        $check = $this->checkData($returnData, 'Falha ao criar dados!');

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        return $returnData;
    }

    public function update($dados, $id, $message = 'Falha ao atualizar dados!')
    {
        $model = $this->model->findOrFail($id);

        $check = $this->checkData($model, $message);

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        $model->fill($dados);

        if (!$model->save()) {
            return [
                'message' => 'Falha ao atualizar dados!',
                'code' => 500,
                'error' => true
            ];
        }

        return $model;
    }

    public function updateInfo($data, $model)
    {
        $personId = $this->relationshipService->updatePersonInfo($data, $model['personInfo_id']);

        // If the checkData method returns an array (error), return it
        if (is_array($personId)) {
            return $personId;
        }

        $address = $this->relationshipService->updateAddress($data, $model['address_id']);

        // If the checkData method returns an array (error), return it
        if (is_array($address)) {
            return $address;
        }

        return ['person_info' => $personId, 'address' => $address,];
    }

    public function delete($id)
    {
        try {
            $resp = $this->model->findOrFail($id);

            if (empty($resp)) {
                return [
                    'message' => 'Falha ao deletar dados!',
                    'code' => 500,
                    'error' => true
                ];
            }

            $resp->delete();

            return $resp;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    // Auxiliary methods
    public function createGallery(array $data)
    {
        $data['uuid'] = Str::uuid();

        return Gallery::create($data);
    }
}

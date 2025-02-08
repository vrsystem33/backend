<?php

namespace App\Repositories\Eloquent\Companies;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\Contracts\Companies\AddressRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

// Models
use App\Models\Companies\Address;

class AddressRepository extends AbstractRepository implements AddressRepositoryInterface
{
    /**
     * @var Address
     */
    protected $model = Address::class;

    public function index(Request $request)
    {
        $params = $request->all();

        $resp = $this->model->orderBy('address', 'asc');

        if (isset($params['term']) && !empty($params['term'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('address', 'like', '%' . $params['term'] . '%')
                    ->orWhere('postal_code', 'like', '%' . $params['term'] . '%')
                    ->orWhere('city', 'like', '%' . $params['term'] . '%')
                    ->orWhere('state', 'like', '%' . $params['term'] . '%');
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

    public function getById($uuid)
    {
        $data = $this->show($uuid);

        $check = $this->checkData($data, 'Endereço não encontrado!');

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

        $address = $this->store($data);

        if (!$address) return [
            'message' => 'Falha ao criar dados!',
            'code' => 500
        ];

        return $address;
    }

    public function updateAddress(Request $request, $uuid)
    {
        $data = $request->all();

        $address = $this->model->findOrFail($uuid);

        if (empty($address)) return [
            'message' => 'Endereço não encontrado!',
            'code' => 500
        ];

        $address->fill($data);

        if (!$address->save()) {
            return [
                'message' => 'Falha ao atualizar dados!',
                'code' => 500
            ];
        }

        return $address;
    }
}

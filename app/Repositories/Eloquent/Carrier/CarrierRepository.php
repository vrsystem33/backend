<?php

namespace App\Repositories\Eloquent\Carrier;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\Contracts\Carrier\CarrierRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

use App\Models\Carriers\Carrier;
use App\Models\Carriers\PersonalInformation;
use App\Models\Carriers\Address;

class CarrierRepository extends AbstractRepository implements CarrierRepositoryInterface
{
    protected $model = Carrier::class;

    public function index(Request $request)
    {
        $params = $request->all();
        $role = $request->user()->role->name;

        $query = $this->model::with(['personalInfo', 'address', 'category'])->orderBy('id', 'asc');

        if ($role != 'super') {
            $query->where('company_id', $request->user()->company_id);
        }

        if (!empty($params['term'] ?? null)) {
            $term = $params['term'];
            $query->where(function ($q) use ($term) {
                $q->whereHas('personalInfo', function ($q2) use ($term) {
                    $q2->where('name', 'like', "%$term%");
                })->orWhereHas('address', function ($q2) use ($term) {
                    $q2->where('city', 'like', "%$term%");
                });
            });
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
        $carrier = $this->model::with(['personalInfo', 'address', 'category'])->findOrFail($uuid);

        $check = $this->checkData($carrier, 'Transportadora não encontrada!');
        if (is_array($check)) {
            return $check;
        }

        return $carrier;
    }

    public function create(array $data)
    {
        $personalData = [
            'uuid' => Str::uuid(),
            'company_id' => $data['company_id'] ?? null,
            'name' => $data['name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'nickname' => $data['nickname'] ?? null,
            'identification' => $data['identification'] ?? null,
            'phone' => $data['phone'] ?? null,
            'secondary_phone' => $data['secondary_phone'] ?? null,
            'email' => $data['email'] ?? null,
        ];

        $personal = PersonalInformation::create($personalData);

        $addressData = [
            'uuid' => Str::uuid(),
            'company_id' => $data['company_id'] ?? null,
            'postal_code' => $data['postal_code'] ?? null,
            'address' => $data['address'] ?? null,
            'number' => $data['number'] ?? null,
            'neighborhood' => $data['neighborhood'] ?? null,
            'complement' => $data['complement'] ?? null,
            'city' => $data['city'] ?? null,
            'state' => $data['state'] ?? null,
        ];

        $address = Address::create($addressData);

        $carrierData = [
            'uuid' => Str::uuid(),
            'company_id' => $data['company_id'] ?? null,
            'personal_info_id' => $personal->uuid,
            'address_id' => $address->uuid,
            'category_id' => $data['category_id'] ?? null,
            'contact_info' => $data['contact_info'] ?? null,
            'status' => $data['status'] ?? true,
        ];

        $carrier = $this->model::create($carrierData);

        if (!$carrier) {
            return [
                'message' => 'Falha ao criar dados!',
                'code' => 500,
            ];
        }

        return $carrier;
    }

    public function updateCarrier(Request $request, $uuid)
    {
        $data = $request->all();
        $carrier = $this->model::findOrFail($uuid);

        $check = $this->checkData($carrier, 'Transportadora não encontrada!');
        if (is_array($check)) {
            return $check;
        }

        if ($carrier->personal_info_id) {
            $personal = PersonalInformation::find($carrier->personal_info_id);
            if ($personal) {
                $personal->fill($data);
                $personal->save();
            }
        }

        if ($carrier->address_id) {
            $address = Address::find($carrier->address_id);
            if ($address) {
                $address->fill($data);
                $address->save();
            }
        }

        $carrier->fill($data);
        if (!$carrier->save()) {
            return [
                'message' => 'Falha ao atualizar dados!',
                'code' => 500,
            ];
        }

        return $carrier;
    }
}

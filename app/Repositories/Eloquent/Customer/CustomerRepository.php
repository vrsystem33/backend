<?php

namespace App\Repositories\Eloquent\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\Contracts\Customer\CustomerRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

/** Uma forma de filtrar o retorno da resposta */
// use App\Http\Resources\CustomerResource;

// Models
use App\Models\Customers\Customer;

class CustomerRepository extends AbstractRepository implements CustomerRepositoryInterface
{
    /**
     * @var Customer
     */
    protected $model = Customer::class;

    public function index(Request $request)
    {
        $params = $request->all();
        $role = $request->user()->role->name;

        $query = $this->model->query();

        $query->select([
            'customers.uuid',
            'customers.company_id',
            'customers.status',
            'person_info.name as person_name',
            'person_info.email as person_email',
            'person_info.phone as person_phone',
            'addresses.address as street',
            'addresses.city',
            'addresses.state',
            'customer_categories.name as category_name'
        ])->join('person_info', 'customers.personInfo_id', '=', 'person_info.uuid')
            ->join('addresses', 'customers.address_id', '=', 'addresses.uuid')
            ->join('customer_categories', 'customers.category_id', '=', 'customer_categories.id')
            ->orderBy('person_info.name', 'asc');

        // Restrições de acordo com o papel do usuário
        if ($role != 'super') {
            $query->where('customers.company_id', $request->user()->company_id);
        }

        // Filtro pelo termo de pesquisa
        if (isset($params['term']) && !empty($params['term'])) {
            $term = $params['term'];
            $query->where(function ($q) use ($term) {
                $q->whereHas('personInfo', function ($q2) use ($term) {
                    $q2->where('name', 'like', '%' . $term . '%');
                })->orWhere('address', 'like', '%' . $term . '%')
                    ->orWhere('email', 'like', '%' . $term . '%')
                    ->orWhere('nickname', 'like', '%' . $term . '%');
            });
        }

        // Filtro por status
        if (isset($params['status']) && !empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        // Paginação ou listagem
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

        $check = $this->checkData($data, 'Cliente não encontrado!');

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        $data->personInfo;
        $data->address;

        // return new CustomerResource($data);
        return $data;
    }

    public function create(array $request)
    {
        return $this->createInfo($request, 'customer');
    }

    public function updateCustomer(Request $request, $uuid)
    {
        $data = $request->all();

        $customer = $this->model->findOrFail($uuid);

        $check = $this->checkData($customer, 'Cliente não encontrado!');

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        $checkInfo = $this->updateInfo($data, $customer);

        // If the checkData method returns an array (error), return it
        if (is_array($checkInfo) && isset($checkInfo['error']) && $checkInfo['error']) {
            return $checkInfo;
        }

        $customer->personInfo;
        $customer->address;

        $customer->fill($data);

        if (!$customer->save()) {
            return [
                'message' => 'Falha ao atualizar dados!',
                'code' => 500,
                'error' => true
            ];
        }

        return $customer;
    }

    // Auxiliary methods

}

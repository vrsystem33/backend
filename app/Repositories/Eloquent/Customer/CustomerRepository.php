<?php

namespace App\Repositories\Eloquent\Customer;

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

    public function index(array $params)
    {
        $role = $params['role'] ?? null;

        $query = $this->model->query();

        $query->select([
            'customers.uuid',
            'customers.company_id',
            'customers.status',
            'customer_personnel_information.name as person_name',
            'customer_personnel_information.email as person_email',
            'customer_personnel_information.phone as person_phone',
            'customer_addresses.address as street',
            'customer_addresses.city',
            'customer_addresses.state',
            'customer_categories.name as category_name'
        ])->leftJoin('customer_personnel_information', 'customers.personal_info_id', '=', 'customer_personnel_information.uuid')
          ->leftJoin('customer_addresses', 'customers.address_id', '=', 'customer_addresses.uuid')
          ->leftJoin('customer_categories', 'customers.category_id', '=', 'customer_categories.id')
          ->orderBy('customer_personnel_information.name', 'asc');

        // Restrições de acordo com o papel do usuário
        if ($role !== 'super' && isset($params['company_id'])) {
            $query->where('customers.company_id', $params['company_id']);
        }

        // Filtro pelo termo de pesquisa
        if (isset($params['term']) && !empty($params['term'])) {
            $term = $params['term'];
            $query->where(function ($q) use ($term) {
                $q->whereHas('personalInfo', function ($q2) use ($term) {
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
            return $query->paginate($params['per_page']);
        }

        return $query->get();
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

    public function create(array $data)
    {
        return $this->createInfo($data, \App\Models\Customers\PersonalInformation::class, \App\Models\Customers\Address::class);
    }

    public function updateCustomer(array $data, $uuid)
    {
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

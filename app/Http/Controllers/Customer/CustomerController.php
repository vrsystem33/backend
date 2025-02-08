<?php

namespace App\Http\Controllers\Customer;

use Throwable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Customer\CustomerRepositoryInterface;

class CustomerController extends Controller
{
    protected $customerRepositoy;

    function __construct(CustomerRepositoryInterface $customerRepositoy)
    {
        $this->customerRepositoy = $customerRepositoy;
    }

    public function listing(Request $request)
    {
        try {
            $response = $this->customerRepositoy->index($request);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function getById($uuid)
    {
        try {
            $response = $this->customerRepositoy->getById($uuid);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function create(Request $request)
    {
        try {
            $response = $this->customerRepositoy->create($request);

            return $this->handleResponse($response, 'create');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = $this->customerRepositoy->updateCustomer($request, $id);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }


    public function delete($uuid)
    {
        try {
            $response = $this->customerRepositoy->delete($uuid);

            return $this->handleResponse($response, 'delete');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }
}
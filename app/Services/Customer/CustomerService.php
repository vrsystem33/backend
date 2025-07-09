<?php

namespace App\Services\Customer;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Services\Service;
use App\Repositories\Contracts\Customer\CustomerRepositoryInterface;
use App\DTOs\CustomerDTO;

class CustomerService extends Service
{
    protected CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAll(Request $request)
    {
        try {
            $filters = $request->all();
            $filters['company_id'] = $request->user()->company_id ?? null;
            $filters['role'] = $request->user()->role->name ?? null;

            return $this->customerRepository->getAll($filters);
        } catch (Throwable $e) {
            return $e;
        }
    }

    public function getById(string $uuid)
    {
        try {
            return $this->customerRepository->getById($uuid);
        } catch (Throwable $e) {
            return $e;
        }
    }

    public function create(CustomerDTO $customerDTO, Request $request)
    {
        try {
            $data = $customerDTO->toArray();
            $data['uuid'] = Str::uuid();
            $data['company_id'] = $request->user()->company_id;

            return $this->customerRepository->create($data);
        } catch (Throwable $e) {
            return $e;
        }
    }

    public function update(CustomerDTO $customerDTO, string $uuid)
    {
        try {
            return $this->customerRepository->update($customerDTO->toArray(), $uuid);
        } catch (Throwable $e) {
            return $e;
        }
    }

    public function delete(string $uuid)
    {
        try {
            return $this->customerRepository->delete($uuid);
        } catch (Throwable $e) {
            return $e;
        }
    }
}

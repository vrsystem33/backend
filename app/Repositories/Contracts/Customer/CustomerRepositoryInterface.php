<?php

namespace App\Repositories\Contracts\Customer;

use App\Repositories\Contracts\CrudRepositoryInterface;
use Illuminate\Http\Request;

interface CustomerRepositoryInterface extends CrudRepositoryInterface
{
    public function index(array $request);

    public function getById(string $uuid);

    public function create(array $request);

    public function updateCustomer(array $data, string $uuid);
}
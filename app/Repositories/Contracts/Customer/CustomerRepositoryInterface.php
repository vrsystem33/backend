<?php

namespace App\Repositories\Contracts\Customer;

use App\Repositories\Contracts\CrudRepositoryInterface;
use Illuminate\Http\Request;

interface CustomerRepositoryInterface extends CrudRepositoryInterface
{
    public function index(Request $request);

    public function getById($id);

    public function create(array $request);

    public function updateCustomer(Request $request, $id);
}
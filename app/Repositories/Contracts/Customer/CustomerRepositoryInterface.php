<?php

namespace App\Repositories\Contracts\Customer;

use App\Repositories\Contracts\CrudRepositoryInterface;
use Illuminate\Http\Request;

interface CustomerRepositoryInterface extends CrudRepositoryInterface
{
    public function getAll(array $filters);

    public function getById(string $id);

    public function create(array $data);

    public function update(array $data, string $id);}
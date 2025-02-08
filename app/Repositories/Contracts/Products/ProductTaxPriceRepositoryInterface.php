<?php

namespace App\Repositories\Contracts\Products;

use App\Models\Users\User;
use App\Repositories\Contracts\CrudRepositoryInterface;

interface ProductTaxRepositoryInterface extends CrudRepositoryInterface
{
    public function index(array $params, User $user, string $role);

    public function getById($id);

    public function create(array $params);

    public function updateUser(array $data, $id);
}
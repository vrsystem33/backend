<?php

namespace App\Repositories\Contracts\Supplier;

use App\Repositories\Contracts\CrudRepositoryInterface;
use Illuminate\Http\Request;

interface SupplierRepositoryInterface extends CrudRepositoryInterface
{
    public function index(Request $request);

    public function getById($id);

    public function create(array $data);

    public function updateSupplier(Request $request, $id);
}
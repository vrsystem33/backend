<?php

namespace App\Repositories\Contracts\Supplier;

use App\Repositories\Contracts\CrudRepositoryInterface;
use Illuminate\Http\Request;

interface CategoryRepositoryInterface extends CrudRepositoryInterface
{
    public function index(Request $request);

    public function getById($id);

    public function create(Request $request);

    public function updateCategory(Request $request, $id);
}
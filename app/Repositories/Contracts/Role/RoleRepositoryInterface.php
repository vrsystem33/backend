<?php

namespace App\Repositories\Contracts\Role;

use App\Repositories\Contracts\CrudRepositoryInterface;
use Illuminate\Http\Request;

interface RoleRepositoryInterface extends CrudRepositoryInterface
{
    public function index(Request $request);

    public function getById($id);

    public function create(Request $request);

    public function updateRole(Request $request, $id);
}
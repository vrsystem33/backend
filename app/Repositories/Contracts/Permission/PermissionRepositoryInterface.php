<?php

namespace App\Repositories\Contracts\Permission;

use App\Repositories\Contracts\CrudRepositoryInterface;
use Illuminate\Http\Request;

interface PermissionRepositoryInterface extends CrudRepositoryInterface
{
    public function index(Request $request);

    public function getById($id);

    public function create(Request $request);

    public function updatePermission(Request $request, $id);
}
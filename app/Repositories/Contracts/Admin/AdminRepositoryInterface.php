<?php

namespace App\Repositories\Contracts\Admin;

use App\Repositories\Contracts\CrudRepositoryInterface;
use Illuminate\Http\Request;

interface AdminRepositoryInterface extends CrudRepositoryInterface
{
    public function index(Request $request);

    public function getById($id);

    public function seed();

    public function migrate();

    public function clearCache();

    public function create(Request $request);

    public function updateAdmin(Request $request, $id);
}

<?php

namespace App\Repositories\Contracts\Companies;

use App\Repositories\Contracts\CrudRepositoryInterface;
use Illuminate\Http\Request;

interface AddressRepositoryInterface extends CrudRepositoryInterface
{
    public function index(Request $request);

    public function getById($id);

    public function create(Request $request);

    public function updateAddress(Request $request, $uuid);
}
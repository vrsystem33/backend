<?php

namespace App\Services\Products;

use Illuminate\Http\Request;

interface ProductServiceInterface
{

    public function index(Request $request);

    public function getById($uuid);

    public function create(Request $request);

    public function updateUser(Request $request, $uuid);

    public function deleteUser(Request $request);
}

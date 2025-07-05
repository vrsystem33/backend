<?php

namespace App\Repositories\Contracts\Carrier;

use Illuminate\Http\Request;

interface CategoryRepositoryInterface
{
    public function index(Request $request);
    public function getById($uuid);
    public function create(Request $request);
    public function updateCategory(Request $request, $uuid);
    public function delete($uuid);
}

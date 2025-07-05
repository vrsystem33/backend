<?php

namespace App\Repositories\Contracts\Carrier;

use Illuminate\Http\Request;

interface CarrierRepositoryInterface
{
    public function index(Request $request);
    public function getById($uuid);
    public function create(array $data);
    public function updateCarrier(Request $request, $uuid);
    public function delete($uuid);
}

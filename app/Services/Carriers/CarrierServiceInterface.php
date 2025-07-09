<?php

namespace App\Services\Carriers;

use Illuminate\Http\Request;

interface CarrierServiceInterface
{
    public function index(Request $request);
    public function getById($uuid);
    public function create(Request $request);
    public function updateCarrier(Request $request, $uuid);
    public function deleteCarrier($uuid);
}

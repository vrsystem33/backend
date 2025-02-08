<?php

namespace App\Services\Companies;

use Illuminate\Http\Request;

interface CompanyServiceInterface
{

    public function index(Request $request);

    public function getById($uuid);

    public function create(Request $request);

    public function updateCompany(Request $request, $uuid);

    public function deleteCompany(Request $request);
}

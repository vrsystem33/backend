<?php

namespace App\Repositories\Contracts\Companies;

use App\Repositories\Contracts\CrudRepositoryInterface;
use Illuminate\Http\Request;

interface CompanyRepositoryInterface extends CrudRepositoryInterface
{
    public function index(array $params);

    public function getById($id);

    public function create(array $data);

    public function updateCompany(array $data, $company);
}
<?php

namespace App\Repositories\Contracts\Companies;

use App\Repositories\Contracts\CrudRepositoryInterface;
use Illuminate\Http\Request;

interface PersonalInformationRepositoryInterface extends CrudRepositoryInterface
{
    public function index(Request $request);

    public function getById($id);

    public function create(Request $request);

    public function updatePersonInfo(array $data, $uuid);
}
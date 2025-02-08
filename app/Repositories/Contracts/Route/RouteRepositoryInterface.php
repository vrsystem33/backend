<?php

namespace App\Repositories\Contracts\Route;

use App\Repositories\Contracts\CrudRepositoryInterface;
use Illuminate\Http\Request;

interface RouteRepositoryInterface extends CrudRepositoryInterface
{
    public function index(Request $request);

    public function getById($id);

    public function create(Request $request);

    public function updateRoute(Request $request, $id);
}
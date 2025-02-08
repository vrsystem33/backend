<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use App\Repositories\Contracts\Admin\AdminRepositoryInterface;
use App\Enums\ExampleEnum;

class AdminController extends Controller
{
    protected $adminRepositoy;

    function __construct(AdminRepositoryInterface $adminRepositoy)
    {
        $this->adminRepositoy = $adminRepositoy;
    }

    public function listing(Request $request)
    {
        try {
            $response = $this->adminRepositoy->index($request);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function getById($uuid)
    {
        try {
            $response = $this->adminRepositoy->getById($uuid);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function seed()
    {
        try {
            $response = $this->adminRepositoy->seed();

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function migrate()
    {
        try {
            $response = $this->adminRepositoy->migrate();

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function clearCache()
    {
        try {
            $response = $this->adminRepositoy->clearCache();

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function create(Request $request)
    {
        try {
            $response = $this->adminRepositoy->create($request);

            return $this->handleResponse($response, 'create');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = $this->adminRepositoy->updateAdmin($request, $id);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }


    public function delete($uuid)
    {
        try {
            $response = $this->adminRepositoy->delete($uuid);

            return $this->handleResponse($response, 'delete');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }
}

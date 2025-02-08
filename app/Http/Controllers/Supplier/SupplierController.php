<?php

namespace App\Http\Controllers\Supplier;

use Throwable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Supplier\SupplierRepositoryInterface;

class SupplierController extends Controller
{
    protected $supplierRepositoy;

    function __construct(SupplierRepositoryInterface $supplierRepositoy)
    {
        $this->supplierRepositoy = $supplierRepositoy;
    }

    public function listing(Request $request)
    {
        try {
            $response = $this->supplierRepositoy->index($request);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function getById($uuid)
    {
        try {
            $response = $this->supplierRepositoy->getById($uuid);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function create(Request $request)
    {
        try {
            $response = $this->supplierRepositoy->create($request);

            return $this->handleResponse($response, 'create');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = $this->supplierRepositoy->updateSupplier($request, $id);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }


    public function delete($uuid)
    {
        try {
            $response = $this->supplierRepositoy->delete($uuid);

            return $this->handleResponse($response, 'delete');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }
}
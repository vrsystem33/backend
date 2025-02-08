<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;
use App\Services\Companies\CompanyServiceInterface;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Enums\ExampleEnum;

class CompanyController extends Controller
{
    protected $companyService;

    function __construct(CompanyServiceInterface $companyService)
    {
        $this->companyService = $companyService;
    }

    public function listing(Request $request)
    {
        try {
            $response = $this->companyService->index($request);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function getById($uuid)
    {
        try {
            $response = $this->companyService->getById($uuid);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function create(Request $request)
    {
        try {
            $response = $this->companyService->create($request);

            return $this->handleResponse($response, 'create');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = $this->companyService->updateCompany($request, $id);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }


    public function delete($uuid)
    {
        try {
            $response = $this->companyService->deleteCompany($uuid);

            return $this->handleResponse($response, 'delete');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }
}
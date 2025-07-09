<?php

namespace App\Http\Controllers\Carrier;

use Throwable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Carriers\CarrierServiceInterface;
use App\Http\Requests\Carrier\CarrierRequest;

class CarrierController extends Controller
{
    protected $carrierService;

    public function __construct(CarrierServiceInterface $carrierService)
    {
        $this->carrierService = $carrierService;
    }

    public function listing(Request $request)
    {
        try {
            $response = $this->carrierService->index($request);
            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function getById($uuid)
    {
        try {
            $response = $this->carrierService->getById($uuid);
            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function create(CarrierRequest $request)
    {
        try {
            $response = $this->carrierService->create($request);
            return $this->handleResponse($response, 'create');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function update(Request $request, $uuid)
    {
        try {
            $response = $this->carrierService->updateCarrier($request, $uuid);
            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function delete($uuid)
    {
        try {
            $response = $this->carrierService->deleteCarrier($uuid);
            return $this->handleResponse($response, 'delete');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }
}

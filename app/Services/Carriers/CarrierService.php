<?php

namespace App\Services\Carriers;

use Throwable;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\Contracts\Carrier\CarrierRepositoryInterface;

class CarrierService extends Service implements CarrierServiceInterface
{
    protected $carrierRepository;

    public function __construct(CarrierRepositoryInterface $carrierRepository)
    {
        $this->carrierRepository = $carrierRepository;
    }

    public function index(Request $request)
    {
        try {
            return $this->carrierRepository->index($request);
        } catch (Throwable $e) {
            return $e;
        }
    }

    public function getById($uuid)
    {
        try {
            return $this->carrierRepository->getById($uuid);
        } catch (Throwable $e) {
            return $e;
        }
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $data['company_id'] = $request->user()->company_id;
            return $this->carrierRepository->create($data);
        } catch (Throwable $e) {
            return $e;
        }
    }

    public function updateCarrier(Request $request, $uuid)
    {
        try {
            return $this->carrierRepository->updateCarrier($request, $uuid);
        } catch (Throwable $e) {
            return $e;
        }
    }

    public function deleteCarrier($uuid)
    {
        try {
            return $this->carrierRepository->delete($uuid);
        } catch (Throwable $e) {
            return $e;
        }
    }
}

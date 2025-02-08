<?php

namespace App\Services\Companies;

use Throwable;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Repositories\Contracts\Companies\AddressRepositoryInterface;
use App\Repositories\Contracts\Companies\PersonalInformationRepositoryInterface;
use App\Repositories\Contracts\Companies\CompanyRepositoryInterface;

class CompanyService extends Service implements CompanyServiceInterface
{
    protected $companyRepository;
    protected $personalInformationRepository;
    protected $addressRepository;

    function __construct(
        CompanyRepositoryInterface $companyRepository,
        PersonalInformationRepositoryInterface $personalInformationRepository,
        AddressRepositoryInterface $addressRepository,
    ) {
        $this->companyRepository = $companyRepository;
        $this->personalInformationRepository = $personalInformationRepository;
        $this->addressRepository = $addressRepository;
    }

    public function index(Request $request)
    {
        try {
            $params = $request->all();

            $response = $this->companyRepository->index($params);

            return $response;
        } catch (Throwable $e) {
            return $e;
        }
    }

    public function getById($uuid)
    {
        try {
            $response = $this->companyRepository->getById($uuid);

            return $response;
        } catch (Throwable $e) {
            return $e;
        }
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();

            $data['uuid'] = Str::uuid();

            $response = $this->companyRepository->create($data);

            if (!isset($response->uuid)) {
                return [
                    'message' => 'Falha ao criar dados!',
                    'error' => true,
                    'code' => 500
                ];
            }

            return $response;
        } catch (Throwable $e) {
            return $e;
        }
    }

    public function updateCompany(Request $request, $uuid)
    {
        try {
            $data = $request->all();

            $company = $this->companyRepository->show($uuid);

            if (empty($company)) return [
                'message' => 'Empresa não encontrada!',
                'error' => true,
                'code' => 500
            ];

            $personalInfoUuid = $company->personalInfo->uuid;
            if ($personalInfoUuid) $this->personalInformationRepository->updatePersonInfo($data, $personalInfoUuid);

            $addressUuid = $company->address->uuid;
            if ($addressUuid) $this->addressRepository->updateAddress($request, $addressUuid);

            $response = $this->companyRepository->updateCompany($data, $company);

            return $response;
        } catch (Throwable $e) {
            return $e;
        }
    }


    public function deleteCompany($uuid)
    {
        try {
            $response = $this->companyRepository->delete($uuid);

            return $response;
        } catch (Throwable $e) {
            return $e;
        }
    }
}

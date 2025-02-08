<?php

namespace App\Repositories\Eloquent\Companies;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\Contracts\Companies\CompanyRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

use App\Utils\Tools;

// Models
use App\Models\Companies\Company;

class CompanyRepository extends AbstractRepository implements CompanyRepositoryInterface
{
    /**
     * @var Company
     */
    protected $model = Company::class;

    /**
     * @var Tools
     */
    protected $tools = Tools::class;

    public function index(array $params)
    {
        // forma eficiente de fazer uma consulta complexa
        $query = $this->model->query();

        $query->select([
            'companies.uuid',
            'companies.status',
            'company_personnel_information.name as person_name',
            'company_personnel_information.email as person_email',
            'company_personnel_information.phone as person_phone',
            'company_addresses.address as street',
            'company_addresses.city',
            'company_addresses.state',
            'company_galleries.name as photo_name'
        ])->join('company_personnel_information', 'companies.personal_info_id', '=', 'company_personnel_information.uuid')
            ->join('company_addresses', 'companies.address_id', '=', 'company_addresses.uuid')
            ->join('company_galleries', 'companies.gallery_id', '=', 'company_galleries.uuid')
            ->orderBy('company_personnel_information.name', 'asc');

        // Filtro pelo termo de pesquisa
        if (isset($params['term']) && !empty($params['term'])) {
            $term = $params['term'];
            $query->where(function ($q) use ($term) {
                $q->whereHas('personalInfo', function ($q2) use ($term) {
                    $q2->where('name', 'like', '%' . $term . '%');
                })->orWhere('address', 'like', '%' . $term . '%')
                    ->orWhere('email', 'like', '%' . $term . '%')
                    ->orWhere('nickname', 'like', '%' . $term . '%');
            });
        }

        // Filtro por status
        if (isset($params['status']) && !empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        // Paginação ou listagem
        if (isset($params['per_page'])) {
            $result = $query->paginate($params['per_page']);
        } else {
            $result = $query->get();
        }

        return $result;
    }

    public function getById($id)
    {
        $company = $this->show($id);

        $check = $this->checkData($company, 'Empresa não encontrada!');

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        $company->personalInfo;
        $company->address;
        $company->gallery;

        return $company;
    }

    public function create(array $data)
    {
        $data['gallery_id'] = $this->createGallery($data['gallery'])->uuid;

        return $this->createInfo($data);
    }

    public function updateCompany(array $data, $company)
    {

        // if (isset($data['photo_full']) && strpos($data['photo_full'], 'data:image') !== false) {
        //     $pathLogo = "{$request->user()->company_id}/logos";
        //     $data['photo_full'] = $this->tools->parse_file($data['photo_full'], $pathLogo, $data['extension']);
        // } else {
        //     unset($data['photo_full']);
        // }

        // if (isset($data['photo_min']) && strpos($data['photo_min'], 'data:image') !== false) {
        //     $pathLogo = "{$request->user()->company_id}/logos";
        //     $data['photo_min'] = $this->tools->parse_file($data['photo_min'], $pathLogo, $data['extension']);
        // } else {
        //     unset($data['photo_min']);
        // }

        $company->fill($data);

        if (!$company->save()) {
            return [
                'message' => 'Falha ao atualizar dados!',
                'code' => 500
            ];
        }

        return $company;
    }
}

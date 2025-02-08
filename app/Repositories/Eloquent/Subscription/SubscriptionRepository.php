<?php

namespace App\Repositories\Eloquent\Subscription;

use App\Http\Requests\Subscription\StoreSubscriptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\Contracts\Subscription\SubscriptionRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

use App\Services\SubscriptionService;

// Models
use App\Models\Subscription;

class SubscriptionRepository extends AbstractRepository implements SubscriptionRepositoryInterface
{
    /**
     * @var Subscription
     */
    protected $model = Subscription::class;

    /**
     * @var SubscriptionService
     */
    protected $subscriptionService;

    // Injeção de dependência do SubscriptionService
    public function __construct(
        Subscription $model,
        SubscriptionService $subscriptionService,
    ) {
        $this->subscriptionService = $subscriptionService;
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $params = $request->all();

        $resp = $this->model->with('company')->orderBy('end_date', 'desc');

        if (isset($params['term']) && !empty($params['term'])) {
            $resp = $resp->where(function ($query) use ($params) {
                $query->orWhere('name', 'like', '%' . $params['term'] . '%')
                    ->orWhere('email', 'like', '%' . $params['term'] . '%')
                    ->orWhere('nickname', 'like', '%' . $params['term'] . '%')
                    ->orWhere('corporate_name', 'like', '%' . $params['term'] . '%')
                    ->orWhere('trade_name', 'like', '%' . $params['term'] . '%');
            });
        }

        if (isset($params['status']) && !empty($params['status'])) {
            $resp = $resp->where('status', $params['status']);
        }

        if (isset($params['per_page'])) {
            $resp = $resp->paginate($params['per_page']);
        } else {
            $resp = $resp->get();
        }

        return $resp;
    }

    public function getById($id)
    {
        $data = $this->show($id);

        $check = $this->checkData($data, 'Informação da assinatura não encontrada');

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        return $data;
    }

    public function create(StoreSubscriptionRequest $request)
    {
        $data = $request->all();

        $data['uuid'] = Str::uuid();

        $subscriptionActive = $this->model->where('company_id', $data['company_id'])->first();

        if ($subscriptionActive) return [
            'message' => 'Já existe uma assinatura para essa empresa!',
            'code' => 500,
            'error' => true
        ];

        $subscription = $this->store($data);

        if (!$subscription) return [
            'message' => 'Falha ao criar dados!',
            'code' => 500,
            'error' => true
        ];

        return $subscription;
    }

    public function renewSubscription(Request $request)
    {
        // Valide o companyId que pode vir de um parâmetro de rota ou do corpo da requisição
        $companyId = $request->input('company_id'); // ou $request->route('company_id')

        // Chama o serviço para renovar a assinatura
        $this->subscriptionService->renewCompanySubscription($companyId);

        return [
            'message' => 'Subscription renewed successfully.',
            'code' => 200,
            'error' => false
        ];
    }

    public function inactiveSubscription(Request $request)
    {
        // Valide o companyId que pode vir de um parâmetro de rota ou do corpo da requisição
        $companyId = $request->input('company_id'); // ou $request->route('company_id')

        // Chama o serviço para renovar a assinatura
        $this->subscriptionService->inactiveCompanySubscription($companyId);

        return [
            'message' => 'Subscription inactived successfully.',
            'code' => 200,
            'error' => false
        ];
    }

    public function cancelSubscription(Request $request)
    {
        // Valide o companyId que pode vir de um parâmetro de rota ou do corpo da requisição
        $companyId = $request->input('company_id'); // ou $request->route('company_id')

        // Chama o serviço para renovar a assinatura
        $this->subscriptionService->cancelCompanySubscription($companyId);

        return [
            'message' => 'Subscription canceled successfully.',
            'code' => 200,
            'error' => false
        ];
    }

    public function updateSubscription(Request $request, $id)
    {
        $data = $request->all();

        $subscription = $this->model->findOrFail($id);

        $check = $this->checkData($subscription, 'Informação da assinatura não encontrada');

        // If the checkData method returns an array (error), return it
        if (is_array($check)) {
            return $check;
        }

        $subscription->fill($data);

        if (!$subscription->save()) {
            return [
                'message' => 'Falha ao atualizar dados!',
                'code' => 500
            ];
        }

        return $subscription;
    }
}

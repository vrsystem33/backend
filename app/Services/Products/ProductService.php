<?php

namespace App\Services\Products;

use Throwable;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Repositories\Contracts\Products\ProductRepositoryInterface;

class ProductService extends Service implements ProductServiceInterface
{
    protected $productRepository;

    function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        try {
            $params = $request->all();
            $user = $request->user();
            $role = $request->user()->role->name;

            $response = $this->productRepository->index($params, $user, $role);

            return $response;
        } catch (Throwable $e) {
            return $e;
        }
    }

    public function getById($uuid)
    {
        try {
            $response = $this->productRepository->getById($uuid);

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
            $data['company_id'] = $request->user()->company_id;

            $response = $this->productRepository->create($data);

            if (!isset($response->uuid)) {
                return [
                    'message' => 'Falha ao criar dados!',
                    'error' => true,
                    'code' => 500
                ];
            }

            // $this->createPrice($response->uuid);

            // $this->createTax($response->uuid);

            return $response;
        } catch (Throwable $e) {
            return $e;
        }
    }

    public function updateUser(Request $request, $uuid)
    {
        try {
            $data = $request->all();

            $response = $this->productRepository->updateUser($data, $uuid);

            return $response;
        } catch (Throwable $e) {
            return $e;
        }
    }


    public function deleteUser($uuid)
    {
        try {
            $response = $this->productRepository->delete($uuid);

            return $response;
        } catch (Throwable $e) {
            return $e;
        }
    }

    // private function subscriptionNotFound($subscription, $companyId): void
    // {
    //     if (!$subscription) {
    //         throw new SubscriptionNotFoundException("No active subscription found for company ID {$companyId}.");
    //     }
    // }
}

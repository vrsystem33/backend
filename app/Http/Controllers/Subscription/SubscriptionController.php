<?php

namespace App\Http\Controllers\Subscription;

use Throwable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subscription\StoreSubscriptionRequest;
use App\Repositories\Contracts\Subscription\SubscriptionRepositoryInterface;

class SubscriptionController extends Controller
{
    protected $subscriptionRepositoy;

    function __construct(SubscriptionRepositoryInterface $subscriptionRepositoy)
    {
        $this->subscriptionRepositoy = $subscriptionRepositoy;
    }

    public function listing(Request $request)
    {
        try {
            $response = $this->subscriptionRepositoy->index($request);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function getById($uuid)
    {
        try {
            $response = $this->subscriptionRepositoy->getById($uuid);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function create(StoreSubscriptionRequest $request)
    {
        try {
            $response = $this->subscriptionRepositoy->create($request);

            return $this->handleResponse($response, 'create');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function renewSubscription(Request $request)
    {
        try {
            $response = $this->subscriptionRepositoy->renewSubscription($request);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function inactiveSubscription(Request $request)
    {
        try {
            $response = $this->subscriptionRepositoy->inactiveSubscription($request);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function cancelSubscription(Request $request)
    {
        try {
            $response = $this->subscriptionRepositoy->cancelSubscription($request);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = $this->subscriptionRepositoy->updateSubscription($request, $id);

            return $this->handleResponse($response);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }


    public function delete($uuid)
    {
        try {
            $response = $this->subscriptionRepositoy->delete($uuid);

            return $this->handleResponse($response, 'delete');
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }
}

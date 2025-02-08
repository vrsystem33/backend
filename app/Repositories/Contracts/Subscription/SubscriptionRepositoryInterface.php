<?php

namespace App\Repositories\Contracts\Subscription;

use App\Http\Requests\Subscription\StoreSubscriptionRequest;
use App\Repositories\Contracts\CrudRepositoryInterface;
use Illuminate\Http\Request;

interface SubscriptionRepositoryInterface extends CrudRepositoryInterface
{
    public function index(Request $request);

    public function getById($id);

    public function create(StoreSubscriptionRequest $request);

    public function renewSubscription(Request $request);

    public function inactiveSubscription(Request $request);

    public function cancelSubscription(Request $request);

    public function updateSubscription(Request $request, $id);
}
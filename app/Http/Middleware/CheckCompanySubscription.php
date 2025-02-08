<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Service
use App\Services\SubscriptionService;

class CheckCompanySubscription
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar se o usuário tem o status ativo
        if (!$request->user()->status) {
            return response()->json([
                'error' => 'User is inactivated.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $companyId = $request->user()->company_id;
        $userRole = $request->user()->role->name;

        if ($userRole != 'super' && !$this->subscriptionService->isCompanySubscriptionActive($companyId)) {
            $this->subscriptionService->inactiveCompanySubscription($companyId);

            return response()->json([
                'error' => 'Company subscription is not active'
            ], 403);
        }

        return $next($request);
    }
}

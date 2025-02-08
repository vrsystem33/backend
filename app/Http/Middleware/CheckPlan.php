<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Service
use App\Services\SubscriptionService;

class CheckPlan
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
    public function handle(Request $request, Closure $next, ...$allowedPlans): Response
    {
        $companyId = $request->user()->company_id;
        $userRole = $request->user()->role->name;

        // 'super' role bypasses plan checks
        if ($userRole === 'super') {
            return $next($request);
        }

        // Check if the company's plan is valid and allowed
        $companyPlan = $this->subscriptionService->getCompanyPlan($companyId);

        if (!$companyPlan || !in_array($companyPlan, $allowedPlans, true)) {
            return response()->json([
                'error' => 'Company plan is not permitted.'
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}

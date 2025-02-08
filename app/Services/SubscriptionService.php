<?php

namespace App\Services;

use App\Models\Subscription;

use App\Exceptions\SubscriptionNotFoundException;

class SubscriptionService
{
    /**
     * Verifica se a assinatura da empresa está ativa.
     */
    public function isCompanySubscriptionActive($companyId): bool
    {
        $subscription = Subscription::where('company_id', $companyId)
            ->where('status', 'active')
            ->latest('end_date')
            ->first();

        return $subscription && !$subscription->isExpired() && $subscription->status == 'active';
    }

    /**
     * Retorna o plano da empresa se a assinatura estiver ativa.
     */
    public function getCompanyPlan($companyId): ?string
    {
        $subscription = Subscription::where('company_id', $companyId)
            ->where('status', 'active')
            ->latest('end_date') // Considerar a assinatura mais recente
            ->first();

        if ($subscription && !$subscription->isExpired()) {
            return $subscription->plan; // Supondo que 'plan' armazena o nome do plano
        }

        return null;
    }

    /**
     * Renova a assinatura de uma empresa.
     */
    public function renewCompanySubscription($companyId): void
    {
        $subscription = Subscription::where('company_id', $companyId)->latest('end_date')->first();

        $this->subscriptionNotFound($subscription, $companyId);

        $subscription->renew();
    }

    /**
     * Inativando a assinatura da empresa.
     */
    public function inactiveCompanySubscription($companyId): void
    {
        $subscription = Subscription::where('company_id', $companyId)->latest('end_date')->first();

        $this->subscriptionNotFound($subscription, $companyId);

        $subscription->inactive();
    }

    /**
     * Cancela a assinatura da empresa.
     */
    public function cancelCompanySubscription($companyId): void
    {
        $subscription = Subscription::where('company_id', $companyId)->latest('end_date')->first();

        $this->subscriptionNotFound($subscription, $companyId);

        $subscription->cancel();
    }

    private function subscriptionNotFound($subscription, $companyId): void
    {
        if (!$subscription) {
            throw new SubscriptionNotFoundException("No active subscription found for company ID {$companyId}.");
        }
    }
}

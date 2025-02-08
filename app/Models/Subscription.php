<?php

namespace App\Models;

use App\Models\Companies\Company;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Subscription extends BaseModel
{
    // Table associated with the model
    protected $table = 'subscriptions';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'company_id',
        'plan',
        'status', // ['active', 'inactive', 'canceled']
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime:d-m-Y H:i:s',
        'end_date' => 'datetime:d-m-Y H:i:s',
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    protected $dates = ['start_date', 'end_date'];

    protected static function boot()
    {
        parent::boot();

        // Adiciona os valores padrão ao criar
        static::creating(function ($subscription) {
            $subscription->start_date = now(); // Data e hora atuais
            $subscription->end_date = now()->addDays(30)->endOfDay(); // vencimento em 30 dias e 23:59:59
        });
    }

    /**
     * Verifica se a assinatura está expirada.
     */
    public function isExpired(): bool
    {
        return $this->end_date && $this->end_date->isPast();
    }

    /**
     * Renova a assinatura por mais 30 dias.
     */
    public function renew(): void
    {
        $this->update([
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(30)->endOfDay(),
            'status' => 'active',
        ]);

        // $this->activateUsersRoles(); // Caso a se pensar
    }

    /**
     * Inactive a assinatura.
     */
    public function inactive(): void
    {
        $this->update([
            'status' => 'inactive',
        ]);

        // $this->deactivateUsersRoles(); // Caso a se pensar
    }

    /**
     * Cancela a assinatura.
     */
    public function cancel(): void
    {
        $this->update([
            'status' => 'canceled',
        ]);

        // $this->deactivateUsersRoles(); // Caso a se pensar
    }

    /**
     * Ativa a assinatura usuarios que pertecem a determinada company.
     */
    public function activateUsersRoles(): void
    {
        $company = $this->company;

        if ($company) {
            foreach ($company->users as $user) {
                $user->update(['status' => true]);
            }
        }
    }

    /**
     * Cancela a assinatura usuarios que pertecem a determinada company.
     */
    public function deactivateUsersRoles(): void
    {
        $company = $this->company;

        if ($company) {
            foreach ($company->users as $user) {
                $user->update(['status' => false]);
            }
        }
    }

    // Relationships
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'uuid');
    }
}

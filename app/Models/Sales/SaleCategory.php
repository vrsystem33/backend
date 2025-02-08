<?php

namespace App\Models\Sales;

use App\Models\BaseModel;
use App\Models\Companies\Company;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleCategory extends BaseModel
{
    // Table associated with the model
    protected $table = 'sale_categories';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'id',
        'company_id',
        'name',
        'status',
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relacionamento com categorias
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}

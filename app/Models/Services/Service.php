<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\BaseModel;

use App\Models\Companies\Company;
use App\Models\Customers\Customer;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Service extends BaseModel
{
    // Table associated with the model
    protected $table = 'services';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'company_id',
        'category_id',
        'name',
        'description',
        'reference',
        'price',
        'duration',
        'status',
    ];

    // Casting attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // Relationships
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}

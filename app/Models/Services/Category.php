<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\BaseModel;

// Relationships with models
use App\Models\Companies\Company;

class Category extends BaseModel
{
    // Table associated with the model
    protected $table = 'service_categories';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    // Fields that can be mass-assigned
    protected $fillable = [
        'id',
        'company_id',
        'name',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [''];

    // Casting attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    /**
     * Override the findOrFail method to allow searching by ID or UUID.
     *
     * @param mixed $value The ID or UUID to search for.
     * @return self|null
     * @throws ModelNotFoundException If no record is found.
     */
    public static function findOrFail($value)
    {
        // Attempt to find the record by ID or UUID
        $record = self::where('id', $value)->first();

        // If no record is found, throw a "not found" exception
        if (!$record) {
            throw new ModelNotFoundException("No query results for model [" . self::class . "] with value " . $value);
        }

        return $record;
    }

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class, 'uuid', 'company_id');
    }

    public function service()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}

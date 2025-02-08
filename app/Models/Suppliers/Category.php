<?php

namespace App\Models\Suppliers;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\BaseModel;

// Relationships with models
use App\Models\Companies\Company;

class Category extends BaseModel
{
    // Table associated with the model
    protected $table = 'supplier_categories';

    // Enable timestamps for created_at and updated_at fields
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
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

    // Relationships with models
    public function company()
    {
        return $this->hasOne(Company::class, 'category_id');
    }
}

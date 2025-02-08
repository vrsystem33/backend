<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Notifications\Notifiable;

class BaseModel extends Model
{
    use HasFactory, Notifiable;

    // Primary key for the model
    protected $primaryKey = 'id';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['id'];

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
        $record = self::where('id', $value)->orWhere('uuid', $value)->first();

        // If no record is found, throw a "not found" exception
        if (!$record) {
            throw new ModelNotFoundException("No query results for model [" . self::class . "] with value " . $value);
        }

        return $record;
    }
}

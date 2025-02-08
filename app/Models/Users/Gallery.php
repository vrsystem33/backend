<?php

namespace App\Models\Users;

use App\Models\BaseModel;
use App\Models\Companies\Company;

use Illuminate\Support\Facades\Storage;

class Gallery extends BaseModel
{
    // Table associated with the model
    protected $table = 'user_galleries';

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
        'photo',
        'name',
        'extension'
    ];

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
     * Accessor to get the URL of the gallery's photo full.
     *
     * Checks if the 'photo' attribute is set and if the file exists
     * on the public disk. If the file exists, returns the public URL of the file.
     * Otherwise, it returns null.
     *
     * @return string|null
     */
    public function getPhotoAttribute()
    {
        if (!isset($this->attributes['photo'])) {
            return null;
        }

        $path = $this->attributes['photo'];

        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }

        return null;
    }

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class, 'uuid', 'gallery_id');
    }
}

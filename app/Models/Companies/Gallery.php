<?php

namespace App\Models\Companies;

use App\Models\BaseModel;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Gallery extends BaseModel
{
    // Table associated with the model
    protected $table = 'company_galleries';

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
        'photo_full',
        'photo_min',
        'file',
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
     * Checks if the 'photo_full' attribute is set and if the file exists
     * on the public disk. If the file exists, returns the public URL of the file.
     * Otherwise, it returns null.
     *
     * @return string|null
     */
    public function getPhotoFullAttribute()
    {
        if (!isset($this->attributes['photo_full'])) {
            return null;
        }

        $path = $this->attributes['photo_full'];

        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }

        return null;
    }

    /**
     * Accessor to get the URL of the gallery's photo min.
     *
     * Checks if the 'photo_min' attribute is set and if the file exists
     * on the public disk. If the file exists, returns the public URL of the file.
     * Otherwise, it returns null.
     *
     * @return string|null
     */
    public function getPhotoMinAttribute()
    {
        if (!isset($this->attributes['photo_min'])) {
            return null;
        }

        $path = $this->attributes['photo_min'];

        if (Storage::disk('public')->exists($path) && isset($this->attributes['photo_full'])) {
            return Storage::url($path);
        }

        return null;
    }

    // Relationships
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'uuid', 'gallery_id');
    }
}

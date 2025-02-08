<?php

namespace App\Models\Users;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Companies\Company;
use App\Models\Employees\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Table associated with the model
    protected $table = 'users';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'uuid',
        'company_id',
        'permission_id',
        'role_id',
        'gallery_id',
        'employee_id',
        'username',
        'name',
        'email',
        'password',
        'status',
        'master',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
        $record = self::where('id', $value)->orWhere('uuid', $value)->first();

        // If no record is found, throw a "not found" exception
        if (!$record) {
            throw new ModelNotFoundException("No query results for model [" . self::class . "] with value " . $value);
        }

        return $record;
    }

    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return ! is_null($this->emailVerifiedAt);
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'emailVerifiedAt' => $this->freshTimestamp(),
        ])->save();
    }

    // Relationships
    public function permission()
    {
        return $this->hasOne(Permission::class, 'uuid', 'permission_id');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'uuid');
    }

    public function gallery()
    {
        return $this->hasOne(Gallery::class, 'uuid', 'gallery_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

}

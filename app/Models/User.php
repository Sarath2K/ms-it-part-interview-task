<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'unique_id',
        'name',
        'email',
        'password',
        'phone',
        'gender',
        'dob',
        'status',
        'address'
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
        'password' => 'hashed',
    ];

    /**
     * Get The Unique Id
     *
     * @return string
     */
    public static function getUserUniqueId()
    {
        return self::getUniqueId(EMPLOYEE_UNIQUE_ID, UNIQUE_ID_LENGTH);
    }

    /**
     * Generate The Unique Id
     *
     * @param $uniqueIdPattern
     * @param $uniqueIdLength
     * @return string
     */
    public static function getUniqueId($uniqueIdPattern, $uniqueIdLength)
    {
        $previousIdObject = self::where('unique_id', 'LIKE', $uniqueIdPattern . '%')->orderBy('unique_id', 'desc')->first();
        $previousId = $previousIdObject ? $previousIdObject->unique_id : ($uniqueIdPattern . str_pad(0, $uniqueIdLength, '0', STR_PAD_LEFT));

        if (!$previousIdObject) {
            return $uniqueIdPattern . str_pad(1, $uniqueIdLength, '0', STR_PAD_LEFT);
        }

        $previousIdNumber = (int)str_replace($uniqueIdPattern, '', $previousId);
        return $uniqueIdPattern . str_pad($previousIdNumber + 1, $uniqueIdLength, '0', STR_PAD_LEFT);
    }
}

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
        'employee_id',
        'f_name',
        'l_name',
        'dob',
        'edu_qualification',
        'gender',
        'address',
        'email',
        'phone',
        'password',
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
        $previousIdObject = self::where('employee_id', 'LIKE', $uniqueIdPattern . '%')->orderBy('employee_id', 'desc')->first();

        if ($previousIdObject) {
            $previousId = $previousIdObject->employee_id;
            $previousIdNumber = (int)substr($previousId, strlen($uniqueIdPattern));
            $newIdNumber = $previousIdNumber + 1;
            $newId = $uniqueIdPattern . str_pad($newIdNumber, $uniqueIdLength, '0', STR_PAD_LEFT);
            return $newId;
        } else {
            return $uniqueIdPattern . '0001';
        }
    }
}

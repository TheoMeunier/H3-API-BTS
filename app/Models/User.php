<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'is_doctor',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function informationPatient(): hasOne
    {
        return $this->hasOne(InformationPatient::class, 'id_patient');
    }

    public function informationDoctor(): hasOne
    {
        return $this->hasOne(InformationDoctor::class, 'id_doctor');
    }

    public function appointmentsDoctor(): HasMany
    {
        return $this->HasMany(Appointment::class, 'doctor_id');
    }

    public function appointmentsPatient(): HasMany
    {
        return $this->HasMany(Appointment::class, 'patient_id');
    }
}

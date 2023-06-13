<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['id_doctor', 'id_patient', 'date', 'content'];

    public function patient(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function doctor(): HasMany
    {
        return $this->hasMany(User::class);
    }
}

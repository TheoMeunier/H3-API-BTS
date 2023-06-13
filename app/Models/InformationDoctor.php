<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InformationDoctor extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id', 'speciality', 'address', 'postal_code', 'city', 'description', 'rates'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}

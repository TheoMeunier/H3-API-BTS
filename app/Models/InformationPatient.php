<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InformationPatient extends Model
{
    use HasFactory;

    protected $fillable = ['phone', 'birthday_date', 'nationality'];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class, 'id_patient');
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}

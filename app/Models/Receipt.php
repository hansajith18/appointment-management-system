<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receipt extends Model
{
    protected $table = 'receipt';

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'external_patient_id', 'external_patient_id')->withDefault();
    }
}

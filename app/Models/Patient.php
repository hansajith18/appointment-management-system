<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $withCount = ['invoices', 'appointments', 'receipts'];

    protected $with = ['invoices', 'appointments', 'receipts'];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'external_patient_id', 'external_patient_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'external_patient_id', 'external_patient_id');
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class, 'external_patient_id', 'external_patient_id');
    }
}

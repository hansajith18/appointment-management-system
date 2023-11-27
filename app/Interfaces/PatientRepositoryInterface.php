<?php

namespace App\Interfaces;

use App\Http\Resources\PatientJsonResource;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Collection;

interface PatientRepositoryInterface
{
    public function getPatientByExternalId(int|Patient $externalId): PatientJsonResource;

    public function getAllPatients(): Collection|array;

    public function deletePatient($externalId): bool;

    public function createPatient(array $patientDetails): Patient;

    public function updatePatient($externalId, array $newDetails): bool;
}

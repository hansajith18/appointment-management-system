<?php

namespace App\Repositories;

use App\Http\Resources\PatientJsonResource;
use App\Interfaces\PatientRepositoryInterface;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Collection;

class PatientRepository implements PatientRepositoryInterface
{

    public function getPatientByExternalId(int|Patient $externalId): PatientJsonResource
    {
        $patient = $externalId;
        if (is_int($externalId)) {
            $patient = Patient::where('external_patient_id', $externalId)->first();
        }
        return new PatientJsonResource($patient);
    }

    public function getAllPatients(): Collection|array
    {
        return Patient::all();
    }

    public function deletePatient($externalId): bool
    {
        // TODO: implement method.
        return false;
    }

    public function createPatient(array $patientDetails): Patient
    {
        // TODO: implement method.
        return new Patient();
    }

    public function updatePatient($externalId, array $newDetails): bool
    {
        // TODO: implement method.
        return false;
    }
}

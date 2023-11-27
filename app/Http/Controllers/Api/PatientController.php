<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\PatientRepositoryInterface;
use App\Models\Patient;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PatientController extends Controller
{
    private PatientRepositoryInterface $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function getPatientDetails(Request $request, Patient $patient)
    {
        $user = $request->user();
        if (!$user) { //TODO: Check roles and permissions with policies/gate-check here or using middleware
            return response([
                'success' => false,
                'message' => 'Illegal attempt..!',
                'data' => null,
            ], Response::HTTP_UNAUTHORIZED);
        }
        try {
            Log::info(
                'GETTING PATIENT DETAILS | LOGGED IN USER: ' . '[' . $user->email . '] ',
                $user->only(['external_user_id', 'email', 'username'])
            );

            return response($this->patientRepository->getPatientByExternalId($patient), Response::HTTP_OK);

        } catch (Throwable $e) {
            Log::error(
                "GETTING PATIENT DETAILS ERROR {$e->getMessage()} | LOGGED IN USER: " . '[' . $user->email . '] ',
                $user->only(['external_user_id', 'email', 'username'])
            );

            return response([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}

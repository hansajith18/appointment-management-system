<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientJsonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $firstReceipts = $this->receipts->sortBy('receipt_date')->first();
        $firstInvoices = $this->invoices->sortBy('receipt_date')->first();
        $firstAppointments = $this->appointments->sortBy('receipt_date')->first();

        return [
            "patient_id" => $this->external_patient_id,
            "first_appointment_id" => $firstAppointments?->appointment_id,
            "invoice" => $this->when($this->invoices_count > 0, $this->invoices->pluck('invoice_no')),
            "total_receipts" => $this->receipts_count,
            "receipts" => $this->when($this->receipts_count > 0, $this->receipts->pluck('receipt_id')),
            "first_receipt_date" => $this->when($firstReceipts?->receipt_date, Carbon::parse($firstReceipts?->receipt_date)->format('Y-m-d'), null),
            "first_invoice_date" => $this->when($firstInvoices?->created_at, Carbon::parse($firstInvoices?->created_at)->format('Y-m-d'), null),
            "first_appointment_date" => $this->when($firstAppointments?->appointment_date, Carbon::parse($firstAppointments?->appointment_date)->format('Y-m-d'), null),
            "patient_created_date" => Carbon::parse($this->created_at)->format('Y-m-d'),
        ];
    }
}

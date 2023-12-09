<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReadingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
        // return [
        //     'id' => $this->id,
        //     'temperature' => $this->temperature,
        //     'frequencyCardiac' => $this->frequency_cardiac,
        //     'pressureSistolic' => $this->pressure_systolic,
        //     'pressureDiastolic' => $this->pressure_diastolic,
        //     'oxigenSaturation' => $this->oxigen_saturation,
        //     'patientId' => $this->patient_id,
        //     'deviceId' => $this->device_id,
        //     'createdAt' => $this->created_at,
        // ];
    }
}

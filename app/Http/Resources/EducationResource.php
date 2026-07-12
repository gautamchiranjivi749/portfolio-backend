<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'institution_name' => $this->institution_name,

            'degree' => $this->degree,

            'field_of_study' => $this->field_of_study,

            'start_year' => $this->start_year,

            'end_year' => $this->end_year,

            'description' => $this->description,

            'sort_order' => $this->sort_order,

            'status' => (bool) $this->status,

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return 
        [
            'id' => $this->id,

            'name' => $this->name,

            'profession' => $this->profession,

            'description' => $this->description,

            'profile_image' => $this->profile_image
                ? asset('storage/'.$this->profile_image)
                : null,

            'resume' => $this->resume
                ? asset('storage/'.$this->resume)
                : null,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}

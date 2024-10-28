<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'status' => $this->status,
            'user_id' => $this->user_id,
            'location_id' => $this->location_id,
            'total' => $this->total_price,
            'date_of_delivery' => $this->date_of_delivery->format('d-m-Y'),
            'user' => $this->when($this->relationLoaded('user'),
                fn () => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email
                ]),
            'location' => $this->when($this->relationLoaded('location'),
                    fn() => [
                    'id' => $this->location->id,
                    'street' => $this->location->street,
                    'building' => $this->location->building,
                    'area' => $this->location->area,
                ]
            ),
            'products' => ProductResource::collection($this->whenLoaded('products'))
        ];
    }
}

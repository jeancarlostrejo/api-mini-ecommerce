<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'category' => $this->when($this->relationLoaded('category'), fn () => [
                'id' => $this->category->id,
                'name' => $this->category->name
            ]),
            'brand' => $this->when($this->relationLoaded('brand'), fn () => [
                'id' => $this->brand->id,
                'name' => $this->brand->name
            ]),
            'price' => $this->pivot?->price ?? $this->price, 
            'quantity' => $this->pivot?->quantity ?? $this->amount,
            'discount' => $this->discount,
            'image' => $this->image,
            'is_trending' => $this->is_trending,
            'is_available' => $this->is_available,
        ];
    }
}

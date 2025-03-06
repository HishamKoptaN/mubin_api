<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'orders' => $this->collection,
            'meta' => [
                'per_page' => $this->resource->perPage(),
                'current_page' => $this->resource->currentPage(),
                'last_page' => $this->resource->lastPage(),
                'total_pages' => $this->resource->lastPage(),
                'has_next_page' => $this->resource->hasMorePages(),
                'has_previous_page' => $this->resource->currentPage() > 1,
                'total' => $this->resource->total(),
            ],
        ];
    }
}

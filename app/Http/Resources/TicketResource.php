<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'reporter_id' => $this->reporter_id,
            'assignee_id' => $this->assignee_id,
            'made_timestamp' => $this->made_timestamp,
            'last_update_on' => $this->last_update_on,
            'categories' => $this->categories->map(fn($cat) => [
                'id' => $cat->id,
                'name' => $cat->name,
            ]),
        ];
    }
}
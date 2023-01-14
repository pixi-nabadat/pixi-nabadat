<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'user'  =>
                [
                    'id' => $this->user->id,
                    'image' => new AttachmentsResource($this->user->attachments),
                    'name' => $this->user->name,
                ],
            'rate_number' => $this->rate_number,
            'comment' => $this->comment,
        ];
    }
}

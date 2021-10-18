<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'loans'             => LoanResource::collection($this->whenLoaded('loans')),
            'remember_token'    => $this->when(! empty($this->remember_token), $this->remember_token),
            'created_at'    => $this->created_at,
            'links'         => [
                [
                    'rel'  => 'self',
                    'href' => "/api/users/{$this->id}"
                ],
                [
                    'rel'  => 'loans',
                    'href' => "/api/users/{$this->id}/loans"
                ],
            ]
        ];
    }
}

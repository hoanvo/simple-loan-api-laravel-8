<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepaymentResource extends JsonResource
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
            'payment_amount'    => $this->payment_amount,
            'links'             => [
                [
                    'rel'  => 'self',
                    'href' => "/api/repayments/{$this->id}"
                ],
                [
                    'rel'  => 'loan',
                    'href' => "/api/loans/{$this->loan_id}"
                ],
                [
                    'rel'  => 'user',
                    'href' => "/api/users/{$this->user_id}"
                ],
            ],
        ];
    }
}

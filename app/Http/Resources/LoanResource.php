<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        # Calculate remaining balance
        $balance = ($this->amount + $this->arrangement_fee) + (($this->amount + $this->arrangement_fee) * ($this->interest_rate / 100));
        foreach ($this->repayments as $repayment) {
            $balance -= $repayment->payment_amount;
        }

        # Calculate installment/repayment amount
        $installmentAmount = (($this->amount + $this->arrangement_fee) / $this->term) +
                             (($this->amount + $this->arrangement_fee) / $this->term) * ($this->interest_rate / 100);

        return [
            'id'                 => $this->id,
            'amount'             => $this->amount,
            'arrangement_fee'    => $this->arrangement_fee,
            'interest_rate'      => $this->interest_rate,
            'installment_amount' => number_format($installmentAmount, 2),
            'remaining_balance'  => number_format($balance, 2),
            'term'               => $this->term,
            'frequency'          => $this->frequency,
            'created_at'         => $this->created_at,
            'user'               => new UserResource($this->whenLoaded('user')),
            'repayments'         => RepaymentResource::collection($this->whenLoaded('repayments')),
            'links'              => [
                [
                    'rel'  => 'self',
                    'href' => "/api/loans/{$this->id}"
                ],
                [
                    'rel'  => 'user',
                    'href' => "/api/users/{$this->user_id}"
                ],
            ],
        ];
    }
}

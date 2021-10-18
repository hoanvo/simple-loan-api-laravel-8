<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\{Model, ModelNotFoundException};

class RepaymentRepository extends Repository
{
	public function model()
	{
		return 'App\Models\Repayment';
	}

	public function resourceModel()
	{
		return 'App\Http\Resources\RepaymentResource';
	}

	public function createRepayment(array $data, Model $loan)
	{
		// Get the user first
		$user = $loan->user;

		if (! $user instanceof \App\Models\User) {
			throw new ModelNotFoundException;
		}

		# Validate required data
		parent::validator($data, self::validatorConstraints())->validate();

		$balance = 0;
		$this->loanValidation($loan, $data['payment_amount'] ?? 0, $balance);

		$repayment = parent::create($data);
		$loan->repayments()->save($repayment);
		$user->repayments()->save($repayment);

		if (0 >= (int) ($balance - $data['payment_amount'])) {
			$loan->is_completed = true;
			$loan->save();
		}

		return $repayment;
	}

	protected function loanValidation(Model $loan, $paymentAmount = 0, &$balance = 0)
	{
		# Completed loan
		if ($loan->is_completed) {
			throw new \Exception('Loan has already been fully paid.');
		}

		# Check remaining balance
		$balance = ($loan->amount + $loan->arrangement_fee) +
				   (($loan->amount + $loan->arrangement_fee) * ($loan->interest_rate / 100));
		foreach ($loan->repayments as $repayment) {
			$balance -= $repayment->payment_amount;
		}

		if ($balance < $paymentAmount) {
			throw new \Exception('Repayment amount is greater then the remaining balance.');
		}
	}

	protected function validatorConstraints()
    {
        return [
			'payment_amount' => 'required',
        ];
    }
}

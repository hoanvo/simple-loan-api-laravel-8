<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class LoanRepository extends Repository
{
	public function model()
	{
		return 'App\Models\Loan';
	}

	public function resourceModel()
	{
		return 'App\Http\Resources\LoanResource';
	}

	public function getByUser(Model $user)
	{
		return $user->loans;
	}

	public function createLoan(array $data, Model $user)
	{
		parent::validator($data, self::validatorConstraints())->validate();

		$loan = parent::create($data);
		$user->loans()->save($loan);

		return $loan;
	}

	protected function validatorConstraints()
    {
        return [
			'amount'          => 'required',
			'interest_rate'   => 'required',
			'term'            => 'required',
        ];
    }
}

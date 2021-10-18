<?php

namespace App\Repositories;

use Illuminate\Support\Facades\{Hash};
use Illuminate\Database\Eloquent\{Model, Collection};

class UserRepository extends Repository
{
	public function model()
	{
		return 'App\User';
	}

	public function resourceModel()
	{
		return 'App\Http\Resources\UserResource';
	}

	public function all(array $columns = ['*'])
	{
		return parent::all($columns);
	}

	public function update(array $data, $modelOrId)
	{
		$this->validator($data);

		return parent::update($data, $modelOrId);
	}

	public function delete($modelOrId)
	{
		return parent::delete($modelOrId);
	}

	protected function validatorConstraints(array $data)
    {
        //
    }
}

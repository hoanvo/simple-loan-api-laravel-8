<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Generator as Faker;
use App\Models\{User, Loan, Repayment};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepaymentTest extends TestCase
{
	use RefreshDatabase;
	use HasFactory;


	public function testRepaymentCreateLoanNotFound()
	{
		$faker = \Faker\Factory::create();
        $user = User::factory()->create([
            'name'          => $faker->firstName,
            'email'         => $faker->unique()->safeEmail,
            'password'      => bcrypt('secret')
        ]);
        $token   = $this->getToken($user);

		$response = $this->json('post', self::API_LOAN . '99/repayments', [], [
			'Authorization' => "Bearer $token"
		]);
		$response->assertStatus(404);
	}

	public function testRepaymentCreateRequiresAll()
	{
		$faker = \Faker\Factory::create();
        $user = User::factory()->create([
            'name'          => $faker->firstName,
            'email'         => $faker->unique()->safeEmail,
            'password'      => bcrypt('secret')
        ]);
        $token   = $this->getToken($user);

		$loan  = Loan::factory()->create();
		$user->loans()->save($loan);

		$response = $this->json('post', self::API_LOAN . $loan->id . '/repayments', [], [
			'Authorization' => "Bearer $token"
		]);
		$response->assertStatus(422)
				 ->assertJson([
					'error' => 'The given data was invalid.',
				 ]);
	}

	public function testRepaymentSuccess()
	{
		$faker = \Faker\Factory::create();
        $user = User::factory()->create([
            'name'          => $faker->firstName,
            'email'         => $faker->unique()->safeEmail,
            'password'      => bcrypt('secret')
        ]);
        $token   = $this->getToken($user);
		$loan = Loan::factory()->create([
			'amount'          => 5000,
			'arrangement_fee' => 0,
			'interest_rate'   => 6,
			'term'            => 12,
		]);
		$user->loans()->save($loan);

		$installmentAmount = (($loan->amount + $loan->arrangement_fee) / $loan->term) + 
                             (($loan->amount + $loan->arrangement_fee) / $loan->term) * ($loan->interest_rate / 100);
		$repayment         = [
			'payment_amount' => $installmentAmount,
			'payment_date'	 => date('Y-m-d')
		];
		$response = $this->json('post', self::API_LOAN . $loan->id . '/repayments', $repayment, [
			'Authorization' => "Bearer $token"
		]);
		$response->assertStatus(200);
	}

	public function testRepaymentCreateWhenPaidTooMuch()
	{
		$faker = \Faker\Factory::create();
        $user = User::factory()->create([
            'name'          => $faker->firstName,
            'email'         => $faker->unique()->safeEmail,
            'password'      => bcrypt('secret')
        ]);
        $token   = $this->getToken($user);
		$loan = Loan::factory()->create([
			'amount'          => 5000,
			'arrangement_fee' => 0,
			'interest_rate'   => 5.9,
			'term'            => 12,
		]);
		$user->loans()->save($loan);

		$repayment         = [
			'payment_amount' => 6000
		];	
		$response = $this->json('post', self::API_LOAN . $loan->id . '/repayments', $repayment, [
			'Authorization' => "Bearer $token"
		]);
		$response->assertStatus(422);
	}
}
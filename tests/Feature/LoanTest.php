<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Generator as Faker;
use App\Models\{User, Loan};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanTest extends TestCase
{
    use RefreshDatabase;
    use HasFactory;

    public function testLoanCreateSuccess()
    {
        $faker = \Faker\Factory::create();
        $user = User::factory()->create([
            'name'          => $faker->firstName,
            'email'         => $faker->unique()->safeEmail,
            'password'      => bcrypt('secret')
        ]);
        $token   = $this->getToken($user);
        
        $newLoan = [
            'amount'            => 15000,
            'interest_rate'     => 10,
            'term'              => 12,
            'arrangement_fee'   => 8,
            'frequency'         => 'weekly',
        ];

        $response = $this->json('POST', self::API_USER . $user->id . '/loans', $newLoan, [
            'Authorization' => "Bearer $token"
        ]);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'amount',
                    'arrangement_fee',
                    'interest_rate',
                    'term',
                    'frequency',
                 ]);
    }

    public function testLoanGet()
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

        $response = $this->json('get', self::API_LOAN . $loan->id, [], [
            'Authorization' => "Bearer $token"
        ]);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'id',
                    'amount',
                    'arrangement_fee',
                    'interest_rate',
                    'term',
                    'frequency',
                 ]);
    }

    public function testLoanGetByUser()
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

        $response = $this->json('get', self::API_USER . $user->id . '/loans', [], [
            'Authorization' => "Bearer $token"
        ]);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                    '*' => ['id', 'amount', 'arrangement_fee', 'interest_rate', 'term', 'frequency',],
                 ]);
    }
}

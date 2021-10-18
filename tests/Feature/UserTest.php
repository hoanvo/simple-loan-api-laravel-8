<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use HasFactory;

    public function testRegisterRequiresPasswordEmailName()
    {
        $response = $this->json('post', self::API_REGISTER)->assertStatus(400);
    }

    public function testRegisterSuccess()
    {
        $newUser = [
            'name' => "Test",
            'email'       => 'test@gmail.com',
            'password'    => 'secret',
        ];

        $response = $this->json('post', self::API_REGISTER, $newUser)->assertStatus(201);
    }

    public function testLoginFailUserNotFound()
    {
        $userToLogin = [
            'email'    => 'test@example.com',
            'password' => 'secrets',
        ];

        $response = $this->json('post', self::API_LOGIN, $userToLogin);
        $response->assertStatus(401);
    }

    public function testLoginSuccess()
    {
        $user = User::factory()->create([
            'email'    => 'testlogin@example.com',
            'password' => bcrypt('secret')
        ]);

        $userToLogin = [
            'email'    => 'testlogin@example.com',
            'password' => 'secret',
        ];

        $response = $this->json('post', self::API_LOGIN, $userToLogin)->assertStatus(200);
    }

    public function testLogoutSuccess()
    {
        $faker = \Faker\Factory::create();
        $user = User::factory()->create([
            'name'          => $faker->firstName,
            'email'         => $faker->unique()->safeEmail,
            'password'      => bcrypt('secret')
        ]);
        $token   = $this->getToken($user);

        $response = $this->json('post', self::API_LOGOUT, [], ['Authorization' => "Bearer $token"]);
        $response->assertStatus(200);
    }

    public function testUserChangePassword()
    {
        $faker = \Faker\Factory::create();
        $user = User::factory()->create([
            'name'          => $faker->firstName,
            'email'         => $faker->unique()->safeEmail,
            'password'      => bcrypt('secret')
        ]);
        $token   = $this->getToken($user);

        $newPassword = [
            'old_password'   => 'secret',
            'new_password'   => 'secret99'
        ];

        $response = $this->json('post', self::API_USER_CHANGE_PASS, $newPassword, [
            'Authorization' => "Bearer $token",
        ])->assertStatus(201);

    }
}

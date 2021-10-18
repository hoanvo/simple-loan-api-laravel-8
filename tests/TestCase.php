<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


	const API_LOAN                  = '/api/loans/';
	const API_REPAYMENT             = '/api/repayments/';
    const API_USER                  = '/api/users/';
    const API_REGISTER              = '/api/auth/register';
    const API_LOGIN                 = '/api/auth/login';
    const API_LOGOUT                = '/api/auth/logout';
    const API_PROFILE               = '/api/auth/user-profile';
    const API_USER_CHANGE_PASS      = '/api/auth/change-pass';

    public function getToken($user) {
        $response = $this->json('post', self::API_LOGIN, [
            'email'    => $user->email,
            'password' => 'secret',
        ]);

        $original = $response->original;
        return $original['access_token'];
    }
}

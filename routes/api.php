<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, LoanController, RepaymentController};
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    # User end points
    Route::post('/login',              [AuthController::class, 'login']);
    Route::post('/register',           [AuthController::class, 'register']);
});

Route::group([
    'middleware' => 'jwt.verify'

], function ($router) {
    # User end points
    Route::post('/auth/logout',             [AuthController::class, 'logout']);
    Route::post('/auth/refresh',            [AuthController::class, 'refresh']);
    Route::get('/auth/user-profile',        [AuthController::class, 'userProfile']);
    Route::post('/auth/change-pass',        [AuthController::class, 'changePassWord']);

    # Loan end points
    Route::get('/loans', 				    [LoanController::class, 'index']);
    Route::post('/users/{user}/loans',       [LoanController::class, 'store']);
	Route::get('/loans/{loan}', 			    [LoanController::class, 'getLoanDetail']);
	Route::get('/users/{user}/loans', 	    [LoanController::class, 'getLoansByUser']);

    # Repayment end points
    Route::get('/repayments', 				[RepaymentController::class, 'index']);
    Route::get('/repayments/{repayment}', 	[RepaymentController::class, 'getRepaymentDetail']);
    Route::post('/loans/{loan}/repayments', 	[RepaymentController::class, 'store']);
    Route::delete('/repayments/{repayment}', [RepaymentController::class, 'delete']);
});

Route::any('{any}', function(){
    return response()->json([
    	'status' => 'error',
        'message' => 'Resource not found'], 404);
})->where('any', '.*');

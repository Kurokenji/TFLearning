<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\HistoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get-user', [TestController::class, 'getUserName']);
Route::post('/register', [RegisterController::class, 'register']);

Route::group([

    'middleware' => 'api',
    // 'prefix' => 'auth'

], function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me/{id}', [AuthController::class, 'me']);

});

Route::post('/quest/create', [QuestController::class, 'createQuest']);
Route::get('/quest/find/{id}', [QuestController::class, 'getQuestById']);
Route::get('/quest/detail', [QuestController::class, 'quest']);
Route::get('/quest/list/{id}', [QuestController::class, 'getQuestByUserId']);
Route::post('/quest/get-by-search-name', [QuestController::class, 'getQuestByContent']);


// test route
Route::post('/test/create', [TestController::class, 'createTest']);
Route::get('test/find/{id}', [TestController::class, 'findQuestById']);
Route::get('/test/detail', [TestController::class, 'testDetail']);
Route::get('/test/list/{id}', [TestController::class, 'getTestByUserId']);

Route::get('do/{id}', [ExamController::class, 'doExam']);
Route::post('submit', [ExamController::class, 'submitExam']);

Route::get('history/{id}', [HistoryController::class, 'getHistory']);
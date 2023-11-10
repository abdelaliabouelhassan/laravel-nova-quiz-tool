<?php

use App\Http\Controllers\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

// Route::get('/', function (Request $request) {
//     //
// });
Route::get('/courses',[CourseController::class,'getCourses']);
Route::post('/save-quiz',[CourseController::class,'storeQuiz']);
Route::get('/get-quiz/{course_id}',[CourseController::class,'getQuiz']);
Route::post('/delete-question',[CourseController::class,'deleteQuestion']);
Route::post('/update-quiz',[CourseController::class,'updateQuiz']);
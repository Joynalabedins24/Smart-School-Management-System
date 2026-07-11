<?php

use App\Http\Controllers\Api\AttendanceApiController;
use App\Http\Controllers\Api\ClassApiController;
use App\Http\Controllers\Api\SectionApiController;
use App\Events\PlayerMoved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Class Module API
Route::get('/classes', [ClassApiController::class, 'index']);
Route::post('/classes', [ClassApiController::class, 'store']);
Route::get('/classes/{id}', [ClassApiController::class, 'show']);
Route::put('/classes/{id}', [ClassApiController::class, 'update']);
Route::delete('/classes/{id}', [ClassApiController::class, 'destroy']);
//Class Module API


//Section Module API
Route::get('/sections', [SectionApiController::class, 'index']);
Route::post('/sections', [SectionApiController::class, 'store']);
Route::get('/sections/{id}', [SectionApiController::class, 'show']);
Route::put('/sections/{id}', [SectionApiController::class, 'update']);
Route::delete('/sections/{id}', [SectionApiController::class, 'destroy']);

// 🔥 important (class wise filter)
Route::get('/sections/class/{class_id}', [SectionApiController::class, 'byClass']);
//Section Module API



//Attendance Management API
Route::prefix('attendance')->group(function () {

    Route::post('/', [AttendanceApiController::class, 'store']);

    Route::get('/date/{date}', [AttendanceApiController::class, 'byDate']);

    Route::get('/class/{class_id}/section/{section_id}', [AttendanceApiController::class, 'byClassSection']);

    Route::get('/student/{student_id}', [AttendanceApiController::class, 'studentHistory']);

});
//Attendance Management API


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('web')->post('/classroom/move', function (Request $request) {
    try {
        // রিকোয়েস্টের ডাটা ঠিকঠাক আছে কিনা তা শিওর হওয়া
        $classroomId = $request->input('classroom_id');
        $playerId = $request->input('player_id');
        $position = $request->input('position');
        $rotation = $request->input('rotation');

        if ($classroomId && $playerId) {
            // ব্রডকাস্ট ফায়ার করা
            event(new PlayerMoved($classroomId, $playerId, $position, $rotation));
        }

        return response()->json(['status' => 'success']);
    } catch (\Exception $e) {
        // যদি কোনো এরর হয়, তা ল্যারাভেল লগে সেভ হবে কিন্তু এপিআই ক্র্যাশ করবে না
        \Log::error('Reverb Sync Error: ' . $e->getMessage());
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

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

// Generic page to redirect to, to demonstrate redirects

Route::get('/you-were-redirected', function () {
    return 'You were just redirected to this page!';
});

// Status code routes

Route::get('/status/{code}', function ($code) {
    if (!array_key_exists($code, Response::$statusTexts)) {
        return response('This status code does not exist.', 400);
    }
    if ($code >= 300 && $code < 400) {
        return redirect('/api/you-were-redirected', $code);
    }
    return response($code . ' ' . Response::$statusTexts[$code], $code);
});

// REST API routes

Route::get('/REST/tasks', function () {
    return App\Models\Task::all();
});

Route::post('/REST/tasks', function (Request $request) {
    return App\Models\Task::create($request->all());
});

Route::put('/REST/tasks/{id}', function (Request $request, $id) {
    $task = App\Models\Task::findOrFail($id);
    $task->update($request->all());
    return $task;
});

Route::delete('/REST/tasks/{id}', function ($id) {
    App\Models\Task::destroy($id);
    return 204;
});


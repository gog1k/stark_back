<?php

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

Route::middleware(['auth:api', 'scope:superuser'])->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'getListAction']);
            Route::get('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'getAction']);
            Route::post('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'updateAction']);
        });
    });
});

Route::middleware(['auth:api', 'scope:superuser,project_admin,project_manager'])->group(function () {
    Route::get('/all', [\App\Http\Controllers\Controller::class, 'helloAction']);

    Route::group(['prefix' => 'games'], function () {
        Route::get('{id}', [\App\Http\Controllers\GamesController::class, 'getAction'])->where('id', '[0-9]+');
        Route::get('/autocomplete-list/{mask}', [\App\Http\Controllers\GamesController::class, 'autocompleteListAction']);
        Route::post('/rating/{mask}', [\App\Http\Controllers\GamesController::class, 'setRatingAction'])->where('id', '[0-9]+');
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::group(['prefix' => 'projects'], function () {
            Route::get('/', [\App\Http\Controllers\Admin\ProjectController::class, 'getListAction']);
            Route::post('/create', [\App\Http\Controllers\Admin\ProjectController::class, 'createAction']);
            Route::get('/{id}', [\App\Http\Controllers\Admin\ProjectController::class, 'getAction'])->where(
                'id',
                '[0-9]+'
            );
            Route::post('/{id}', [\App\Http\Controllers\Admin\ProjectController::class, 'updateAction'])->where(
                'id',
                '[0-9]+'
            );
            Route::get('/allowList', [\App\Http\Controllers\Admin\ProjectController::class, 'allowListAction']);
        });
        Route::group(['prefix' => 'room-items'], function () {
            Route::get('/', [\App\Http\Controllers\Admin\RoomItemController::class, 'getListAction']);
            Route::post('/create', [\App\Http\Controllers\Admin\RoomItemController::class, 'createAction']);
            Route::get('/{id}', [\App\Http\Controllers\Admin\RoomItemController::class, 'getAction'])->where(
                'id',
                '[0-9]+'
            );
            Route::post('/{id}', [\App\Http\Controllers\Admin\RoomItemController::class, 'updateAction'])->where(
                'id',
                '[0-9]+'
            );
        });
        Route::group(['prefix' => 'achievements'], function () {
            Route::get('/', [\App\Http\Controllers\Admin\AchievementController::class, 'getListAction']);
            Route::post('/create', [\App\Http\Controllers\Admin\AchievementController::class, 'createAction']);
            Route::get('/{id}', [\App\Http\Controllers\Admin\AchievementController::class, 'getAction'])->where(
                'id',
                '[0-9]+'
            );
            Route::post('/{id}', [\App\Http\Controllers\Admin\AchievementController::class, 'updateAction'])->where(
                'id',
                '[0-9]+'
            );
        });
        Route::group(['prefix' => 'events'], function () {
            Route::get('/', [\App\Http\Controllers\Admin\EventsController::class, 'getListAction']);
            Route::get('/allowList/{id}', [\App\Http\Controllers\Admin\EventsController::class, 'allowListAction']
            )->where('id', '[0-9]+');
            Route::post('/create', [\App\Http\Controllers\Admin\EventsController::class, 'createAction']);
            Route::get('/{id}', [\App\Http\Controllers\Admin\EventsController::class, 'getAction'])->where(
                'id',
                '[0-9]+'
            );
            Route::post('/{id}', [\App\Http\Controllers\Admin\EventsController::class, 'updateAction'])->where(
                'id',
                '[0-9]+'
            );
        });
        Route::group(['prefix' => 'room-item-templates'], function () {
            Route::get('/', [\App\Http\Controllers\Admin\ItemTemplateController::class, 'indexAction']);
            Route::get('/allowList/{id}', [\App\Http\Controllers\Admin\ItemTemplateController::class, 'allowListAction']
            )->where('id', '[0-9]+');
            Route::get('{id}', [\App\Http\Controllers\Admin\ItemTemplateController::class, 'getAction'])->where(
                'id',
                '[0-9]+'
            );
            Route::get(
                '/template/{templateId}',
                [\App\Http\Controllers\Admin\ItemTemplateController::class, 'listForTemplateAction']
            );
            Route::get(
                '/item/{itemId}',
                [\App\Http\Controllers\Admin\ItemTemplateController::class, 'listForItemAction']
            );
            Route::post('/create', [\App\Http\Controllers\Admin\ItemTemplateController::class, 'createAction']);
            Route::post('/update', [\App\Http\Controllers\Admin\ItemTemplateController::class, 'updateAction']);
        });
    });
});

Route::middleware(['auth:apiKey'])->group(function () {
    Route::group(['prefix' => 'api'], function () {
        Route::group(['prefix' => 'event'], function () {
            Route::post('/create', [\App\Http\Controllers\Api\EventsController::class, 'createAction']);
        });
    });
});

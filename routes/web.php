<?php

use App\Http\Controllers\DocsController;
use App\Http\Controllers\ImpersonateController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Softnweb\ComingSoon\Http\Controllers\ComingSoonController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/docs/{file?}', [DocsController::class, 'index'])->name('docs.index');

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::any('/billing',function(){
    return view('subscribe');
})->name('billing');

$authMiddleware = config('jetstream.guard')
? 'auth:'.config('jetstream.guard')
: 'auth';

Route::group(['middleware' => [$authMiddleware, 'has_team', 'verified']], function () {
    Route::get('/impersonate/take/{id}/{guardName?}', [ImpersonateController::class, 'take'])->name('impersonate');
    Route::get(
        '/impersonate/leave',
        [\Lab404\Impersonate\Controllers\ImpersonateController::class, 'leave']
    )->name('impersonate.leave');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

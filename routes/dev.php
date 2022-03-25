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


Route::middleware(['auth:web', 'charter.user'])->get('/id', function (Request $request) {
    dd(auth());
})->name('id');

Route::get('memberships/{membership}', function (\App\Models\Membership $membership) {
    return $membership->toJson();
});

<?php

use App\Http\Controllers\LawController;
use App\Models\Law;
use Carbon\CarbonInterval;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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


Route::get('/', function () {
    $nr_words_per_minute = 250;
    $minutes = Law::all()->sum('number_of_words') / $nr_words_per_minute;

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'number_of_words' => Law::all()->sum('number_of_words'),
        'nr_words_per_minute' => Law::all()->sum('nr_words_per_minute'),
        'how_long_to_read' => CarbonInterval::minutes($minutes)->cascade(),
    ]);
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('laws', LawController::class);

require __DIR__ . '/auth.php';

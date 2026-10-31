<?php

use App\Support\Catalog;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'hero' => config('catalog.hero'),
        'heroProduct' => Catalog::find(config('catalog.hero.product_id')),
        'products' => Catalog::products(),
        'categories' => config('catalog.categories'),
    ]);
})->name('home');

Route::view('/contatti', 'contatti')->name('contatti');

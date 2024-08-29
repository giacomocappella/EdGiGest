<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\View;

Route::get('/', 'App\Http\Controllers\View\Dashboard')->name('dashboard');
Route::get('/newclient', 'App\Http\Controllers\View\CreateClient')->name('create.client');
Route::get('/tickets', 'App\Http\Controllers\View\GetTicket')->name('get.tickets');
Route::get('/newticket','App\Http\Controllers\View\CreateTicket')->name('create.ticket');

Route::post('/newclient/store', 'App\Http\Controllers\Post\StoreClient')->name('store.client');
Route::post('/newticket/store', 'App\Http\Controllers\Post\StoreTicket')->name('store.ticket');

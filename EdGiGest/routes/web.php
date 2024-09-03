<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\View;

Route::get('/', 'App\Http\Controllers\View\Dashboard')->name('dashboard');
Route::get('/newclient', 'App\Http\Controllers\View\CreateClient')->name('create.client');
Route::get('/tickets', 'App\Http\Controllers\View\GetTickets')->name('get.tickets');
Route::get('/tickets/tasks','App\Http\Controllers\View\GetTasks')->name('get.tasks');
Route::get('/newticket','App\Http\Controllers\View\CreateTicket')->name('create.ticket');
Route::get('/newtask','App\Http\Controllers\View\CreateTask')->name('create.task');

Route::post('/newclient/store', 'App\Http\Controllers\Post\StoreClient')->name('store.client');
Route::post('/newticket/store', 'App\Http\Controllers\Post\StoreTicket')->name('store.ticket');
Route::post('/newtask/store', 'App\Http\Controllers\Post\StoreTask')->name('store.task');
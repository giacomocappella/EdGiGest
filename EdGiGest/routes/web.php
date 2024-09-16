<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\View;

Route::get('/', 'App\Http\Controllers\View\Dashboard')->name('dashboard');
Route::get('/newclient', 'App\Http\Controllers\View\CreateClient')->name('create.client');
Route::get('/tickets', 'App\Http\Controllers\View\GetTickets')->name('get.tickets');
Route::get('/ticket/tasks','App\Http\Controllers\View\GetTasks')->name('get.tasks');
Route::get('/newticket','App\Http\Controllers\View\CreateTicket')->name('create.ticket');

Route::post('/newclient/store', 'App\Http\Controllers\Post\StoreClient')->name('store.client');
Route::post('/newticket/store', 'App\Http\Controllers\Post\StoreTicket')->name('store.ticket');
Route::post('/newtask/store/{idticket}', 'App\Http\Controllers\Post\StoreTask')->name('store.task');

Route::put('/ticket/suspend', 'App\Http\Controllers\Put\SuspendTicket')->name('suspend.ticket');
Route::put('/ticket/close', 'App\Http\Controllers\Put\CloseTicket')->name('close.ticket');
Route::put('/ticket/reopen', 'App\Http\Controllers\Put\ReopenTicket')->name('reopen.ticket');
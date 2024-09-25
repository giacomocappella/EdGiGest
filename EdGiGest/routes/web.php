<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\View;

Route::get('/', 'App\Http\Controllers\View\Dashboard')->name('dashboard');
Route::get('/newclient', 'App\Http\Controllers\View\CreateClient')->name('create.client');
Route::get('/ticket', 'App\Http\Controllers\View\GetTickets')->name('get.tickets');
Route::get('/ticket/tasks','App\Http\Controllers\View\GetTasks')->name('get.tasks');
Route::get('/newticket','App\Http\Controllers\View\CreateTicket')->name('create.ticket');
Route::get('/receiptPDF','App\Http\Controllers\View\MakePDF@download')->name('create.pdf');



Route::post('/newclient/store', 'App\Http\Controllers\Post\StoreClient')->name('store.client');
Route::post('/newticket/store', 'App\Http\Controllers\Post\StoreTicket')->name('store.ticket');
Route::post('/newtask/store/{idticket}', 'App\Http\Controllers\Post\StoreTask')->name('store.task');

Route::put('/ticket/suspend', 'App\Http\Controllers\Put\SuspendTicket')->name('suspend.ticket');
Route::put('/ticket/close', 'App\Http\Controllers\Put\CloseTicket@closeNoMail')->name('close.ticket');
Route::put('/ticket/reopen', 'App\Http\Controllers\Put\ReopenTicket')->name('reopen.ticket');
Route::put('/ticket/close/withmail','App\Http\Controllers\Put\CloseTicket@CloseWithMail')->name('close.ticket.mail');
Route::put('/ticket/close/nomail','App\Http\Controllers\Put\CloseTicket@CloseNoMail')->name('close.ticket.nomail');
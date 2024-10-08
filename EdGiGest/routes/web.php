<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\View;

Route::get('/', 'App\Http\Controllers\View\Dashboard')->name('dashboard');
Route::get('/newclient', 'App\Http\Controllers\View\CreateClient')->name('create.client');
Route::get('/client', 'App\Http\Controllers\View\GetClients')->name('get.clients');
Route::get('/client/edit', 'App\Http\Controllers\View\EditClient')->name('edit.client');
Route::get('/ticket', 'App\Http\Controllers\View\GetTickets')->name('get.tickets');
Route::get('/ticket/tasks','App\Http\Controllers\View\GetTasks')->name('get.tasks');
Route::get('/newticket','App\Http\Controllers\View\CreateTicket')->name('create.ticket');
Route::get('/ticket/newtask','App\Http\Controllers\View\CreateTask')->name('create.task');
Route::get('/ticket/task/edit','App\Http\Controllers\View\EditTask')->name('edit.task');
Route::get('/ticket/task/delete','App\Http\Controllers\Delete\DeleteTask')->name('delete.task');
Route::get('/ticket/edit','App\Http\Controllers\View\EditTicket')->name('edit.ticket');
Route::get('/dashboard-receipts','App\Http\Controllers\View\DashboardReceipts')->name('dashboard.receipts');
Route::get('/newreceipt','App\Http\Controllers\View\CreateReceipt')->name('create.receipt');
Route::get('/newreceipt/searchtickets','App\Http\Controllers\View\GetTicketsSelectedClient')->name('get.ticket.selected.client');
Route::get('/newreceipt/pdf','App\Http\Controllers\View\MakePDF')->name('make.pdf');
Route::get('/newreceipt/pdf/{filename}', 'App\Http\Controllers\View\PreviewPDF')->name('preview.pdf');

Route::post('/newclient/store', 'App\Http\Controllers\Post\StoreClient')->name('store.client');
Route::post('/newticket/store', 'App\Http\Controllers\Post\StoreTicket')->name('store.ticket');
Route::post('/ticket/newtask/store/', 'App\Http\Controllers\Post\StoreTask')->name('store.task');
Route::post('/newreceipt/store/', 'App\Http\Controllers\Post\StoreReceipt')->name('store.receipt');
Route::post('/newreceipt/store/mail', 'App\Http\Controllers\Post\StoreReceipt@StoreSendMail')->name('store.receipt.mail');

Route::put('/ticket/suspend', 'App\Http\Controllers\Put\SuspendTicket')->name('suspend.ticket');
Route::put('/ticket/close', 'App\Http\Controllers\Put\CloseTicket@closeNoMail')->name('close.ticket');
Route::put('/ticket/reopen', 'App\Http\Controllers\Put\ReopenTicket')->name('reopen.ticket');
Route::put('/ticket/close/withmail','App\Http\Controllers\Put\CloseTicket@CloseWithMail')->name('close.ticket.mail');
Route::put('/ticket/close/nomail','App\Http\Controllers\Put\CloseTicket@CloseNoMail')->name('close.ticket.nomail');
Route::put('/ticket/task/edit/store','App\Http\Controllers\Put\StoreEditTask')->name('store.edit.task');
Route::put('/ticket/edit/store','App\Http\Controllers\Put\StoreEditTicket')->name('store.edit.ticket');


<?php

namespace App\Http\Controllers\View;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\View;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;



Route::get('/', function(){
    if(Auth::user()->current_team_id=='0000000000'){
        return app(Dashboard::class)();
    }
    else
        return app(DashboardClient::class)();
})->middleware('auth');
Route::get('/dashboard/client', 'App\Http\Controllers\View\DashboardClient')->name('dashboard.client')->middleware('auth');
Route::get('/newclient', 'App\Http\Controllers\View\CreateClient')->name('create.client')->middleware('auth');
Route::get('/client', 'App\Http\Controllers\View\GetClients')->name('get.clients')->middleware('auth');
Route::get('/client/edit', 'App\Http\Controllers\View\EditClient')->name('edit.client')->middleware('auth');
Route::get('/ticket', 'App\Http\Controllers\View\GetTickets')->name('get.tickets')->middleware('auth');
Route::get('/ticket/tasks','App\Http\Controllers\View\GetTasks')->name('get.tasks')->middleware('auth');
Route::get('/ticket/tasks/client','App\Http\Controllers\View\GetTasksClient')->name('get.tasks.client')->middleware('auth');
Route::get('/newticket','App\Http\Controllers\View\CreateTicket')->name('create.ticket')->middleware('auth');
Route::get('/newservice','App\Http\Controllers\View\CreateService')->name('create.service')->middleware('auth');
Route::get('/ticket/newtask','App\Http\Controllers\View\CreateTask')->name('create.task')->middleware('auth');
Route::get('/ticket/task/edit','App\Http\Controllers\View\EditTask')->name('edit.task')->middleware('auth');
Route::get('/ticket/task/delete','App\Http\Controllers\Delete\DeleteTask')->name('delete.task')->middleware('auth');
Route::get('/ticket/edit','App\Http\Controllers\View\EditTicket')->name('edit.ticket')->middleware('auth');
Route::get('/newreceipt','App\Http\Controllers\View\CreateReceipt')->name('create.receipt')->middleware('auth');
Route::get('/newreceipt/searchtickets','App\Http\Controllers\View\GetTicketsSelectedClient')->name('get.ticket.selected.client')->middleware('auth');
Route::get('/newreceipt/pdf','App\Http\Controllers\View\MakePDF')->name('make.pdf')->middleware('auth');
Route::get('/newreceipt/pdf/{filename}', 'App\Http\Controllers\View\PreviewPDF')->name('preview.pdf')->middleware('auth');
Route::get('/newreceipt/pdf/double/{filename}', 'App\Http\Controllers\View\PreviewPDF2tech')->name('preview2tech.pdf')->middleware('auth');
Route::get('/profile', 'App\Http\Controllers\View\ViewProfile')->name('profile')->middleware('auth');



Route::post('/newclient/store', 'App\Http\Controllers\Post\StoreClient')->name('store.client')->middleware('auth');
Route::post('/newticket/store', 'App\Http\Controllers\Post\StoreTicket')->name('store.ticket')->middleware('auth');
Route::post('/ticket/newtask/store/', 'App\Http\Controllers\Post\StoreTask')->name('store.task')->middleware('auth');
Route::post('/newservice/store', 'App\Http\Controllers\Post\StoreService')->name('store.service')->middleware('auth');
Route::post('/newreceipt/store/', 'App\Http\Controllers\Post\StoreReceipt')->name('store.receipt')->middleware('auth');
Route::post('/newreceipt/store/mail', 'App\Http\Controllers\Post\StoreReceipt@StoreSendMail')->name('store.receipt.mail')->middleware('auth');
Route::post('/newreceipt/store/double', 'App\Http\Controllers\Post\StoreReceipt2')->name('store.receipt2')->middleware('auth');
Route::post('/newreceipt/store/double/mail/', 'App\Http\Controllers\Post\StoreReceipt2@StoreSendMail')->name('store.receipt.mail2')->middleware('auth');

Route::put('/ticket/suspend', 'App\Http\Controllers\Put\SuspendTicket')->name('suspend.ticket')->middleware('auth');
Route::put('/ticket/close', 'App\Http\Controllers\Put\CloseTicket@closeNoMail')->name('close.ticket')->middleware('auth');
Route::put('/ticket/reopen', 'App\Http\Controllers\Put\ReopenTicket')->name('reopen.ticket')->middleware('auth');
Route::put('/ticket/close/withmail','App\Http\Controllers\Put\CloseTicket@CloseWithMail')->name('close.ticket.mail')->middleware('auth');
Route::put('/ticket/close/nomail','App\Http\Controllers\Put\CloseTicket@CloseNoMail')->name('close.ticket.nomail')->middleware('auth');
Route::put('/ticket/task/edit/store','App\Http\Controllers\Put\StoreEditTask')->name('store.edit.task')->middleware('auth');
Route::put('/ticket/edit/store','App\Http\Controllers\Put\StoreEditTicket')->name('store.edit.ticket')->middleware('auth');
Route::put('/client/edit/store','App\Http\Controllers\Put\StoreEditClient')->name('store.edit.client')->middleware('auth');
Route::put('/profile/edit/store', 'App\Http\Controllers\Put\StoreEditProfile')->name('store.edit.profile')->middleware('auth');

Route::get('/dashboard', function () { return redirect('/'); });
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
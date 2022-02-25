<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});



Auth::routes();
//Auth::routes(['register' => false ]);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('payment',PaymentController::class);
Route::resource('section',SectionController::class);
Route::resource('product',ProductController::class);

Route::get('/sections/{id}','PaymentController@getproducts');
Route::get('/InvoicesDetailes/{id}','InvoiceDetailController@show');
Route::get('download/{invoice_number}/{file_name}','InvoiceDetailController@get_file');
Route::get('View_file/{invoice_number}/{file_name}','InvoiceDetailController@open_file');
Route::get('/edit_invoice/{id}','PaymentController@edit');
Route::get('/Status_show/{id}','PaymentController@show')->name('Status_show');
Route::post('/status_update/{id}','PaymentController@status_update')->name('status_update');

Route::get('/invoice_paid','PaymentController@invoice_paid');
Route::get('/invoice_unpaid','PaymentController@invoice_unpaid');
Route::get('/invoice_partial','PaymentController@invoice_partial');

Route::resource('invoice_archive',ArchiveController::class);


Route::get('Print_invoice/{id}','PaymentController@Print_invoice');

Route::get('export_payment', 'PaymentController@export');

Route::get('reports', 'InovicesReport@index');
Route::POST('report_search', 'InovicesReport@report_search');

Route::get('customers', 'CustomerReport@index');
Route::POST('customers_search', 'CustomerReport@customers_search');

Route::get('MarkAsRead_all','PaymentController@MarkAsRead_all')->name('MarkAsRead_all');

Route::get('/redirect/{service}', 'SocialController@redirect');
Route::get('/callback/{service}', 'SocialController@callback');




Route::post('InvoiceAttachments', 'AttachmentController@store');
Route::post('delete_file','InvoiceDetailController@destroy')->name('delete_file');


Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');

    });




Route::get('/{page}','AdminController@index');

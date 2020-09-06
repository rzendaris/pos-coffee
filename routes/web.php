<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function() {
    /**
     * POS Management
     */
    Route::get('/', 'Admin\PosManagementController@mainTransaction');
    Route::post('add-transaction', 'Admin\PosManagementController@postTransaction');
    Route::get('check-customer/{customer_id}', 'Admin\PosManagementController@detailCustomer');
    Route::get('pos', 'Admin\PosManagementController@pos');

    /**
     * User Management
     */

    Route::get('user-management', 'Admin\UserManagementController@mainUser');
    Route::get('add-user', 'Admin\UserManagementController@addUserView');
    Route::post('add-user', 'Admin\UserManagementController@postUser');
    Route::post('update-user', 'Admin\UserManagementController@updateUser');
    Route::post('inactive-user', 'Admin\UserManagementController@inactiveUser');

    /**
     * Item Management
     */

    Route::get('item-management', 'Admin\ItemManagementController@mainProduct');
    Route::get('add-product', 'Admin\ItemManagementController@addProductView');
    Route::post('add-product', 'Admin\ItemManagementController@postProduct');
    Route::post('update-product', 'Admin\ItemManagementController@updateProduct');
    Route::post('inactive-product', 'Admin\ItemManagementController@inactiveProduct');

    /**
     * Branch Management
     */
    Route::get('branch-management', 'Admin\BranchManagementController@mainBranch');
    Route::get('add-branch', 'Admin\BranchManagementController@addBranch');
    Route::post('add-branch', 'Admin\BranchManagementController@postBranch');
    Route::post('update-branch', 'Admin\BranchManagementController@updateBranch');

    /**
     * Type Management
     */
    Route::get('category-management', 'Admin\CategoryManagementController@mainCategory');
    Route::post('add-category', 'Admin\CategoryManagementController@postCategory');
    Route::post('update-category', 'Admin\CategoryManagementController@updateCategory');

    /**
     * Customer Management
     */
    Route::get('customer-management', 'Admin\CustomerManagementController@mainCustomer');
    Route::get('add-customer', 'Admin\CustomerManagementController@addCustomerView');
    Route::post('add-customer', 'Admin\CustomerManagementController@postCustomer');
    Route::post('update-customer', 'Admin\CustomerManagementController@updateCustomer');

    /**
     * Order & Payment Management
     */
    Route::get('order-list', 'Admin\OrderManagementController@allOrder');
    Route::get('order-list/cetak-pdf/{id}', 'Admin\OrderManagementController@cetakPdf');
    Route::get('order-list/cetak-retur-pdf/{id}', 'Admin\OrderManagementController@cetakReturPdf');
    Route::get('order-list/cetak-suratJalan-pdf/{id}', 'Admin\OrderManagementController@cetakSuratJalan');
    Route::get('nota-penjualan/cetak-pdf/{id}', 'Admin\OrderManagementController@cetakNota');
    Route::get('order-retur', 'Admin\OrderManagementController@orderRetur');
    Route::post('update-order', 'Admin\OrderManagementController@updateOrder');
    Route::post('cancel-order', 'Admin\OrderManagementController@cancelOrder');
    Route::post('delivered-order', 'Admin\OrderManagementController@deliveredOrder');
    Route::get('payment', 'Admin\OrderManagementController@mainPayment');
    Route::post('payment', 'Admin\OrderManagementController@postPayment');
    Route::get('check-transaction/{transaction_number}', 'Admin\OrderManagementController@checkTransaction');

    Route::get('order-undelivered', 'Admin\OrderManagementController@undeliveredOrder');
    Route::get('order-delivered', 'Admin\OrderManagementController@deliveredOrderPos');

    /**
     * Chef Management
     */
    Route::get('chef-order-undelivered', 'Chef\ChefManagementController@undeliveredOrder');
    Route::post('chef-update-order', 'Chef\ChefManagementController@updateOrder');

    /**
     * Barista Management
     */
    Route::get('barista-order-undelivered', 'Barista\BaristaManagementController@undeliveredOrder');
    Route::post('barista-update-order', 'Barista\BaristaManagementController@updateOrder');

    /**
     * Report Management
     */
    Route::get('report-management', 'Admin\ReportManagementController@mainReport');
    Route::get('generate-report/{type}', 'Admin\ReportManagementController@generateReport');
});

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes(['verify' => true]);

// HOME
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// STAFF
Route::get('staff', [App\Http\Controllers\HomeController::class, 'Staff'])->name('staff')->middleware('role:Finance,Admin,Super');
Route::get('new-staff', [App\Http\Controllers\HomeController::class, 'newStaff'])->name('new-staff')->middleware('role:Finance,Admin,Super');

// CONTRIBUTIONS
Route::get('contributors', [App\Http\Controllers\HomeController::class, 'Contributors'])->name('contributors')->middleware('role:Finance,Admin,Super');
Route::get('new-contributor', [App\Http\Controllers\HomeController::class, 'newContributor'])->name('new-contributor')->middleware('role:Finance,Admin,Super');
Route::post('/paycsub', [App\Http\Controllers\PaymentsController::class, 'paySub'])->name('paycsub')->middleware('role:Finance,Admin,Super');
Route::get('ctransactions', [App\Http\Controllers\PaymentsController::class, 'cTransactions'])->name('ctransactions')->middleware('role:Finance,Admin,Super');
Route::get('/delete-csub/{pid}', [App\Http\Controllers\PaymentsController::class, 'deleteCsub'])->name('delete-csub')->middleware('role:Super');
Route::get('my-contributions', [App\Http\Controllers\PaymentsController::class, 'myContributions'])->name('my-contributions')->middleware('role:Contributor,Admin,Super');
Route::get('online-payment', [App\Http\Controllers\PaymentsController::class, 'onlinePayment'])->name('online-payment')->middleware('role:Contributor,Admin,Super');


// CLIENTS
Route::get('clients', [App\Http\Controllers\HomeController::class, 'clients'])->name('clients')->middleware('role:Finance,Admin,Super');
Route::get('new-client', [App\Http\Controllers\HomeController::class, 'newClient'])->name('new-client')->middleware('role:Finance,Admin,Super');
Route::post('saveClient', [App\Http\Controllers\HomeController::class, 'saveClient'])->name('saveClient')->middleware('role:Client,Admin,Super');
Route::get('edit-client/{cid}', [App\Http\Controllers\HomeController::class, 'editClient'])->name('edit-client')->middleware('role:Client,Admin,Super');
Route::get('delete-client/{cid}', [App\Http\Controllers\HomeController::class, 'destroy'])->name('delete-client')->middleware('role:Super');

// PRODUCTS
Route::get('products', [App\Http\Controllers\ProductsController::class, 'index'])->name('products');
Route::get('supplier-products/{cid}', [App\Http\Controllers\ProjectsController::class, 'clientProjects'])->name('client-projects')->middleware('role:Finance,Admin,Super');
Route::get('/new-product/{cid}', [App\Http\Controllers\ProjectsController::class, 'create'])->name('new-project')->middleware('role:Finance,Admin,Super');
Route::get('/edit-product/{pid}', [App\Http\Controllers\ProductsController::class, 'editProduct'])->name('edit-product')->middleware('role:Finance,Admin,Super');
Route::get('/addproduct', [App\Http\Controllers\ProductsController::class, 'newProduct'])->name('addproduct')->middleware('role:Finance,Admin,Super');
Route::post('save-product', [App\Http\Controllers\ProductsController::class, 'store'])->name('save-product')->middleware('role:Finance,Admin,Super');
Route::get('/product-dashboard/{pid}', [App\Http\Controllers\ProductsController::class, 'productDashboard'])->name('product-dashboard')->middleware('role:Client,Admin,Super');

//TASK
Route::get('tasks', [App\Http\Controllers\TasksController::class, 'index'])->name('tasks');
Route::get('project-task/{tid}', [App\Http\Controllers\TasksController::class, 'create'])->name('project-task');
Route::get('task/{tid}', [App\Http\Controllers\TasksController::class, 'viewTask'])->name('task');
Route::post('change_task_status', [App\Http\Controllers\TasksController::class, 'change_task_status'])->name('change_task_status');
Route::get('del-task/{tid}', [App\Http\Controllers\TasksController::class, 'destroy'])->name('del-task')->middleware('role:Admin,Super');
Route::get('new-task', [App\Http\Controllers\TasksController::class, 'newTask'])->name('new-task');
Route::post('saveTask', [App\Http\Controllers\TasksController::class, 'saveTask'])->name('saveTask');
Route::get('/completetask/{id}', [App\Http\Controllers\TasksController::class, 'completetask'])->name('completetask')->middleware('role:Client,Admin,Contributor,Pastor,Super');
Route::get('/inprogresstask/{id}', [App\Http\Controllers\TasksController::class, 'inprogresstask'])->name('inprogresstask')->middleware('role:Client,Admin,Contributor,Pastor,Super');


//REPORT
Route::get('new-task-report/{tid}', [App\Http\Controllers\MilestoneReportsController::class, 'newtaskReport'])->name('new-task-report')->middleware('role:Finance,Admin,Super');
Route::post('addtaskreport', [App\Http\Controllers\MilestoneReportsController::class, 'store'])->name('addtaskreport')->middleware('role:Finance,Admin,Super');
Route::get('task-report/{trid}', [App\Http\Controllers\MilestoneReportsController::class, 'milestonetaskReport'])->name('task-report')->middleware('role:Finance,Admin,Super');
Route::post('change_task_report_status', [App\Http\Controllers\MilestoneReportsController::class, 'change_task_report_status'])->name('change_task_report_status')->middleware('role:Finance,Admin,Super');

//FILES
Route::get('/add-file', [App\Http\Controllers\ProductFilesController::class, 'create'])->name('add-file')->middleware('role:Finance,Admin,Super');
Route::get('/addp-file/{pid}', [App\Http\Controllers\ProductFilesController::class, 'addProductFile'])->name('addp-file')->middleware('role:Finance,Admin,Super');

Route::post('save-file', [App\Http\Controllers\ProductFilesController::class, 'store'])->name('save-file')->middleware('role:Finance,Admin,Super');
Route::get('/file/{fid}', [App\Http\Controllers\ProductFilesController::class, 'file'])->name('file')->middleware('role:Finance,Admin,Super');
Route::get('/delete-file/{fid}', [App\Http\Controllers\ProductFilesController::class, 'destroy'])->name('delete-file')->middleware('role:Finance,Admin,Super');

// SUPPLIERS
Route::get('/suppliers', [App\Http\Controllers\SuppliersController::class, 'index'])->name('suppliers')->middleware('role:Admin,Super,Staff');
Route::post('/addsupplier', [App\Http\Controllers\SuppliersController::class, 'store'])->name('addsupplier')->middleware('role:Admin,Super,Staff');
Route::get('/supplier/{id}', [App\Http\Controllers\SuppliersController::class, 'supplier'])->name('supplier');
Route::get('/delete-sup/{id}', [App\Http\Controllers\SuppliersController::class, 'destroy'])->name('delete-sup')->middleware('role:Admin,Super,Staff');

// SUPPLIES
Route::get('/supplies', [App\Http\Controllers\MaterialSuppliesController::class, 'index'])->name('supplies')->middleware('role:Admin,Super,Staff');
Route::post('/addsupply', [App\Http\Controllers\MaterialSuppliesController::class, 'store'])->name('addsupply')->middleware('role:Admin,Super,Staff');
Route::get('/supply/{id}', [App\Http\Controllers\MaterialSuppliesController::class, 'supply'])->name('supply');
Route::get('/delete-sp/{id}', [App\Http\Controllers\MaterialSuppliesController::class, 'destroy'])->name('delete-sp')->middleware('role:Admin,Super,Staff');

// ACCOUNT HEADS
Route::get('/account-heads', [App\Http\Controllers\AccountheadsController::class, 'index'])->name('account-heads')->middleware('role:Finance,Admin,Super');
Route::post('/addaccounthead', [App\Http\Controllers\AccountheadsController::class, 'store'])->name('addaccounthead')->middleware('role:Finance,Admin,Super');
Route::get('/delete-acch/{id}', [App\Http\Controllers\AccountheadsController::class, 'destroy'])->name('delete-acch')->middleware('role:Super');

// ACCOUNT HEADS
Route::get('/categories', [App\Http\Controllers\CategoriesController::class, 'index'])->name('categories')->middleware('role:Finance,Admin,Super');
Route::post('/addcategory', [App\Http\Controllers\CategoriesController::class, 'store'])->name('addcategory')->middleware('role:Finance,Admin,Super');
Route::get('/delete-cat/{id}', [App\Http\Controllers\CategoriesController::class, 'destroy'])->name('delete-cat')->middleware('role:Super');


// SUBSCRIPTION PLANS
Route::get('/subplans', [App\Http\Controllers\SubscriptionPlansController::class, 'index'])->name('subplans')->middleware('role:Finance,Admin,Super');
Route::post('/addsubplans', [App\Http\Controllers\SubscriptionPlansController::class, 'store'])->name('addsubplans')->middleware('role:Finance,Admin,Super');

//PRODUCT SUBSCRIPTION
Route::get('/product_subscription', [App\Http\Controllers\SubscriptionsController::class, 'index'])->name('product_subscription')->middleware('role:Finance,Admin,Super');
Route::post('/addsubscription', [App\Http\Controllers\SubscriptionsController::class, 'store'])->name('addsubscription')->middleware('role:Client,Admin,Super');
Route::post('/paysub', [App\Http\Controllers\PaymentsController::class, 'store'])->name('paysub')->middleware('role:Finance,Admin,Super');
Route::get('/delete-subs/{id}', [App\Http\Controllers\SubscriptionsController::class, 'destroy'])->name('delete-subs')->middleware('role:Super');
Route::get('/client-subscriptions/{cid}', [App\Http\Controllers\SubscriptionsController::class, 'clientSubs'])->name('client-supscriptions')->middleware('role:Client,Admin,Super');
Route::post('/topUp', [App\Http\Controllers\SubscriptionsController::class, 'topUp'])->name('topUp')->middleware('role:Admin,Super');


// GENERATE UPLOADS
Route::get('/generate-upload', [App\Http\Controllers\SubscriptionsController::class, 'UploadTemplate'])->name('generate-upload')->middleware('role:Finance,Admin,Super');
Route::get('/generate-stoppage', [App\Http\Controllers\SubscriptionsController::class, 'generateStoppage'])->name('generate-stoppage')->middleware('role:Finance,Admin,Super');
Route::get('/upload-payments', [App\Http\Controllers\PaymentsController::class, 'addPayments'])->name('upload-payments')->middleware('role:Finance,Admin,Super');
Route::post('/uploadPayments', [App\Http\Controllers\PaymentsController::class, 'uploadPayments'])->name('uploadPayments')->middleware('role:Finance,Admin,Super');


//PAYMENTS
Route::get('/payments', [App\Http\Controllers\PaymentsController::class, 'index'])->name('payments')->middleware('role:Finance,Admin,Super');
Route::get('/item-payments/{pid}', [App\Http\Controllers\PaymentsController::class, 'itemPayments'])->name('item-payments')->middleware('role:Client,Finance,Admin,Super');

Route::get('/delete-payment/{pid}', [App\Http\Controllers\PaymentsController::class, 'destroy'])->name('delete-payment')->middleware('role:Super');

// TRANSACTIONS
Route::get('/transactions', [App\Http\Controllers\TransactionsController::class, 'index'])->name('transactions')->middleware('role:Finance,Admin,Super');
Route::post('/addtransaction', [App\Http\Controllers\TransactionsController::class, 'store'])->name('addtransaction')->middleware('role:Finance,Admin,Super');
Route::get('/delete-trans/{id}', [App\Http\Controllers\TransactionsController::class, 'delTrans'])->name('delete-trans')->middleware('role:Finance,Super');

// SETTINGS
Route::post('/settings', [App\Http\Controllers\HomeController::class, 'settings'])->name('settings')->middleware('role:Super');

// COMMUNICATION
Route::get('/communications', [App\Http\Controllers\HomeController::class, 'communications'])->name('communications')->middleware('role:Admin,Super');
Route::post('/sendsms', [App\Http\Controllers\HomeController::class, 'sendSMS'])->name('sendsms')->middleware('role:Admin,Super');
Route::get('/sentmessages', [App\Http\Controllers\HomeController::class, 'sentSMS'])->name('sentmessages')->middleware('role:Admin,Super');


//LOGOUT
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class,'logout']);

// ARTISAN COMMANDS
Route::get('/artisan1/{command}', [App\Http\Controllers\HomeController::class, 'Artisan1'])->middleware('role:Super');
Route::get('/artisan2/{command}/{param}', [App\Http\Controllers\HomeController::class, 'Artisan2'])->middleware('role:Super');

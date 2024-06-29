<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['auth'])->group(function () {
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::get('/imageuploader', [App\Http\Controllers\ImageUploadController::class, 'index']);
Route::post('imageupload', [App\Http\Controllers\ImageUploadController::class, 'upload'])->name('imageupload');

Route::get('/employeeavatar', [App\Http\Controllers\hr\EmployeeAvatarController::class, 'index']);
Route::post('employeeavatarupload', [App\Http\Controllers\hr\EmployeeAvatarController::class, 'create'])->name('employeeavatarupload');

Route::namespace('admin')->middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::name('admin.')->group(function () {

            Route::resource('users', UsersController::class);

            Route::get('/assignuserrole/{id}/', [App\Http\Controllers\admin\UsersController::class, 'assignrole'])->name('user.assignrole');

            Route::get('/activateuser/{id}/', [App\Http\Controllers\admin\UsersController::class, 'activate'])->name('user.activate');

            Route::get('/changepassword/{id}/', [App\Http\Controllers\admin\UsersController::class, 'changepassword'])->name('user.changepassword');


            Route::post('/changepasswordSubmit', [App\Http\Controllers\admin\UsersController::class, 'changepasswordSubmit'])->name('user.changepasswordSubmit');


            Route::get('/deactivateuser/{id}/', [App\Http\Controllers\admin\UsersController::class, 'deactivate'])->name('user.deactivate');

            Route::post('/assignuserrole', [App\Http\Controllers\admin\UsersController::class, 'assignroleSubmit'])->name('user.assignroleSubmit');

            Route::get('/assignuserpermision/{id}/', [App\Http\Controllers\admin\UsersController::class, 'assignpermission'])->name('user.assignpermission');

            Route::post('/assignuserpermision', [App\Http\Controllers\admin\UsersController::class, 'assignpermissionSubmit'])->name('user.assignpermissionSubmit');

            Route::get('/updatetheme', [App\Http\Controllers\admin\UsersController::class, 'updatetheme'])->name('updatetheme');
            Route::resource('settings', SettingsController::class);
            Route::get('/basecurrency', [App\Http\Controllers\admin\SettingsController::class, 'basecurrency'])->name('basecurrency.create');

            Route::post('/basecurrencysubmit', [App\Http\Controllers\admin\SettingsController::class, 'basecurrencysubmit'])->name('basecurrency.submit');

            Route::get('/foreigncurrency', [App\Http\Controllers\admin\SettingsController::class, 'foreigncurrency'])->name('foreigncurrency.create');

            Route::post('/foreigncurrencysubmit', [App\Http\Controllers\admin\SettingsController::class, 'foreigncurrencysubmit'])->name('foreigncurrency.submit');


            Route::get('/subscription', [App\Http\Controllers\admin\SettingsController::class, 'subscription'])->name('subscription.create');

            Route::post('/subscriptionsubmit', [App\Http\Controllers\admin\SettingsController::class, 'subscriptionSubmit'])->name('subscription.submit');

            Route::resource('roles', RolesController::class);
            Route::resource('permissions', PermissionsController::class);
            Route::get('/assignrolepermissions/{id}/', [App\Http\Controllers\admin\RolesController::class, 'assignpermissions'])->name('roles.assignpermissions');

            Route::post('/assignpermissionSubmit', [App\Http\Controllers\admin\RolesController::class, 'assignpermissionSubmit'])->name('roles.assignpermissionSubmit');


        });
    });
});



Route::namespace('hr')->middleware(['auth'])->group(function () {
    Route::prefix('hr')->group(function () {
        Route::name('hr.')->group(function () {

Route::get('/employees/{id}/update_avatar/', [App\Http\Controllers\hr\EmployeesController::class, 'update_avatar'])->name('employees.update_avatar');

Route::post('/employees/{id}/update_avatarSubmit/', [App\Http\Controllers\hr\EmployeesController::class, 'update_avatarSubmit'])
->name('employees.update_avatarSubmit');

        });
    });
});

Route::namespace('Accounts')->middleware(['auth'])->group(function () {
    Route::prefix('accounts')->group(function () {
        Route::name('accounts.')->group(function () {

Route::resource('rates', CurrencyRatesController::class);
Route::resource('invoices', InvoiceController::class);
Route::get('/invoiceslist/{id}/', [App\Http\Controllers\rent\InvoiceController::class, 'index'])->name('invoices.list');


Route::get('/invoicesonproperty/{id}/', [App\Http\Controllers\Accounts\InvoiceController::class, 'invoicesonproperty'])->name('invoices.invoicesonproperty');

Route::get('/loadinvoiceitemes/{id}/', [App\Http\Controllers\Accounts\InvoiceController::class, 'loadinvoiceitemes'])->name('loadinvoiceitemes');

Route::get('/loadinvoiceitemesOnEdit/{id}/', [App\Http\Controllers\Accounts\InvoiceController::class, 'loadinvoiceitemesOnEdit'])->name('loadinvoiceitemesOnEdit');

Route::get('/computeinvoiceamount', [App\Http\Controllers\Accounts\InvoiceController::class, 'computeinvoiceamount'])->name('computeinvoiceamount');
Route::get('/invoiceprint/{id}/', [App\Http\Controllers\Accounts\InvoiceController::class, 'print'])->name('invoices.print');

Route::get('/invoiceapprove/{id}/', [App\Http\Controllers\Accounts\InvoiceController::class, 'approve'])->name('invoices.approve');

Route::put('/invoiceapprove/{id}/', [App\Http\Controllers\Accounts\InvoiceController::class, 'approveSubmit'])->name('invoices.approveSubmit');

Route::get('/invoicedelete/{id}/', [App\Http\Controllers\Accounts\InvoiceController::class, 'delete'])->name('invoices.delete');

Route::get('/invoicepayment/{id}/', [App\Http\Controllers\Accounts\InvoiceController::class, 'payment'])->name('invoices.payment');

Route::post('/payment', [App\Http\Controllers\Accounts\InvoiceController::class, 'paymentSubmit'])->name('invoices.paymentSubmit');

Route::post('/prepaymentsSubmit', [App\Http\Controllers\Accounts\InvoiceController::class, 'prepaymentsSubmit'])->name('invoices.prepaymentsSubmit');

Route::get('/invoicepayments', [App\Http\Controllers\Accounts\InvoiceController::class, 'invoicepayments'])->name('invoices.invoicepayments');

Route::get('/invoicepaymentscreate', [App\Http\Controllers\Accounts\InvoiceController::class, 'invoicepaymentscreate'])->name('invoices.invoicepayments-create');

Route::get('/invoicepaymentsinvoicedcreate', [App\Http\Controllers\Accounts\InvoiceController::class, 'invoicepaymentsinvoicedcreate'])->name('invoices.invoicepayments-invoicedcreate');

Route::get('/getpropertyunits/{id}/', [App\Http\Controllers\Accounts\InvoiceController::class, 'getpropertyunits'])->name('getpropertyunits');

Route::get('/paymentsgetitems/{id}/', [App\Http\Controllers\Accounts\InvoiceController::class, 'getitems'])->name('payments.getitems');

Route::get('/invoicegetdetails', [App\Http\Controllers\Accounts\InvoiceController::class, 'getdetails'])->name('invoices.getdetails');


        });
    });
});



Route::namespace('crm')->middleware(['auth'])->group(function () {
    Route::prefix('crm')->group(function () {
        Route::name('crm.')->group(function () {

            Route::resource('clients', ClientsController::class);
            Route::get('/gallery/{id}/filetype/{filetype}', [App\Http\Controllers\crm\ClientsController::class, 'gallery'])
->name('documents.gallery');

Route::get('/setfeaturedimage', [App\Http\Controllers\crm\ClientsController::class, 'setfeaturedimage'])->name('documents.setfeaturedimage');

Route::get('/profilepic/{id}/', [App\Http\Controllers\crm\ClientsController::class, 'profilepic'])->name('clientprofilepic');

        });
    });
});


Route::namespace('main')->middleware(['auth'])->group(function () {
    Route::prefix('main')->group(function () {
        Route::name('main.')->group(function () {

            Route::resource('documents', Documentscontroller::class);
            Route::get('/documents/{id}/filetype/{filetype}', [App\Http\Controllers\main\Documentscontroller::class, 'index'])
->name('documents.list');
Route::get('/gallery/{id}/filetype/{filetype}', [App\Http\Controllers\main\Documentscontroller::class, 'gallery'])
->name('documents.gallery');

Route::get('/adddocuments/{id}/filetype/{filetype}', [App\Http\Controllers\main\Documentscontroller::class, 'create'])
->name('documents.add');

Route::get('/upload/{id}/filetype/{filetype}', [App\Http\Controllers\main\Documentscontroller::class, 'store'])
->name('documents.upload');


Route::post('/upload', [App\Http\Controllers\main\Documentscontroller::class, 'store'])
->name('upload');

Route::get('/documentspreview/{id}', [App\Http\Controllers\main\Documentscontroller::class, 'preview'])->name('documents.preview');

Route::get('/documentsdownload/{id}', [App\Http\Controllers\main\Documentscontroller::class, 'download'])->name('documents.download');

Route::get('/setfeaturedimage', [App\Http\Controllers\main\Documentscontroller::class, 'setfeaturedimage'])->name('documents.setfeaturedimage');

        });
    });
});



Route::namespace('rent')->middleware(['auth'])->group(function () {
    Route::prefix('rent')->group(function () {
        Route::name('rent.')->group(function () {

            Route::resource('properties', PropertiesController::class);

            Route::get('/profilepic/{id}/', [App\Http\Controllers\rent\PropertiesController::class, 'profilepic'])->name('propertyprofilepic');

            Route::get('/getpropertydetails/{id}/', [App\Http\Controllers\rent\PropertiesController::class, 'getpropertydetails'])->name('getpropertydetails');

            Route::resource('units', UnitsController::class);
            Route::get('/addunit/{id}/', [App\Http\Controllers\rent\UnitsController::class, 'create'])->name('units.add');

            Route::get('/getunitcurrencies/{id}/', [App\Http\Controllers\rent\UnitsController::class, 'getunitcurrencies'])->name('getunitcurrencies');

            Route::get('/unitsonproperty/{id}/', [App\Http\Controllers\rent\UnitsController::class, 'unitsonproperty'])->name('units.unitsonproperty');

            Route::get('/tenantunits/{id}/', [App\Http\Controllers\rent\TenantUnitsController::class, 'index'])->name('tenantunits');

            Route::get('/tenantunitdelete/{id}/', [App\Http\Controllers\rent\TenantUnitsController::class, 'delete'])->name('tenantunits.delete');

            Route::get('/tenantunitscreate/{id}/', [App\Http\Controllers\rent\TenantUnitsController::class, 'create'])->name('tenantunits.add');

            Route::resource('tenantUnits', TenantUnitsController::class);

            Route::get('/getunitdetails', [App\Http\Controllers\rent\UnitsController::class, 'getunitdetails'])->name('getunitdetails');

            Route::get('/computetodate', [App\Http\Controllers\rent\TenantUnitsController::class, 'computetodate'])->name('computetodate');

            Route::get('/floorsonproperty/{id}/', [App\Http\Controllers\rent\FloorsController::class, 'floorsonproperty'])->name('floors.floorsonproperty');
            Route::resource('floors', FloorsController::class);

            Route::get('/floorscreate/{id}/', [App\Http\Controllers\rent\FloorsController::class, 'create'])->name('floors.add');

            Route::get('/paymentschedules/{id}/', [App\Http\Controllers\rent\PaymentScheduleController::class, 'index'])->name('paymentschedules.list');

            Route::resource('payments', PaymentsController::class);

            Route::get('/paymentdelete/{id}/', [App\Http\Controllers\rent\PaymentsController::class, 'delete'])->name('payment.delete');

            Route::get('/paymentslist/{id}/', [App\Http\Controllers\rent\PaymentsController::class, 'index'])->name('payments.list');

            Route::get('/paymentdocuments/{id}/', [App\Http\Controllers\rent\PaymentsController::class, 'documents'])->name('payment.documents');

            Route::get('/paymentsprint/{id}/', [App\Http\Controllers\rent\PaymentsController::class, 'print'])->name('payments.print');

            Route::get('/paymentscreate/{id}/', [App\Http\Controllers\rent\PaymentsController::class, 'create'])->name('payments.add');

            Route::get('/gettenantunits', [App\Http\Controllers\rent\TenantUnitsController::class, 'gettenantunits'])->name('gettenantunits');

            Route::get('/gettenantunitschedules/{id}/', [App\Http\Controllers\rent\PaymentScheduleController::class, 'gettenantunitschedules'])->name('gettenantunitschedules');

            Route::get('/gettenantunitamount', [App\Http\Controllers\rent\TenantUnitsController::class, 'gettenantunitamount'])->name('gettenantunitamount');

            Route::get('/computedueamount', [App\Http\Controllers\rent\PaymentScheduleController::class, 'computedueamount'])->name('computedueamount');

            Route::resource('expenses', ExpensesController::class);

            Route::get('/expensescreate/{id}/', [App\Http\Controllers\rent\ExpensesController::class, 'create'])->name('expenses.add');

            Route::get('/expenseslist/{id}/', [App\Http\Controllers\rent\ExpensesController::class, 'index'])->name('expenses.list');

            Route::get('/expensesupload/{id}/', [App\Http\Controllers\rent\ExpensesController::class, 'upload'])->name('expenses.upload');

            Route::get('/expenseeapprove/{id}/', [App\Http\Controllers\rent\ExpensesController::class, 'approve'])->name('expense.approve');

            Route::put('/expenseapprove/{id}/', [App\Http\Controllers\rent\ExpensesController::class, 'approveSubmit'])->name('expense.approveSubmit');

            Route::get('/expensedelete/{id}/', [App\Http\Controllers\rent\ExpensesController::class, 'delete'])->name('expense.delete');

            Route::get('/expensedocuments/{id}/', [App\Http\Controllers\rent\ExpensesController::class, 'documents'])->name('expense.documents');

        });
    });
});



Route::namespace('Reports')->middleware(['auth'])->group(function () {
    Route::prefix('reports')->group(function () {
        Route::name('reports.')->group(function () {

Route::resource('reports', ReportsController::class);
Route::get('/unpaidrentreport', [App\Http\Controllers\Reports\ReportsController::class, 'unpaidrent'])
->name('unpaidrent');

Route::get('/paymentsreport', [App\Http\Controllers\Reports\ReportsController::class, 'payments'])
->name('payments');

Route::get('/collectionsreport', [App\Http\Controllers\Reports\ReportsController::class, 'collections'])
->name('collections');

Route::get('/overview', [App\Http\Controllers\Reports\ReportsController::class, 'overview'])
->name('overview');

Route::get('/revenue', [App\Http\Controllers\Reports\ReportsController::class, 'revenue'])
->name('revenue');

Route::get('/leasestatus', [App\Http\Controllers\Reports\ReportsController::class, 'leasestatus'])
->name('leasestatus');

Route::post('/collectionsprint', [App\Http\Controllers\Reports\ReportsController::class, 'collectionsPrint'])->name('collections.print');

Route::get('/projections', [App\Http\Controllers\Reports\ReportsController::class, 'projections'])->name('projections');

Route::get('/generalprojections', [App\Http\Controllers\Reports\ReportsController::class, 'generalprojections'])->name('generalprojections');

Route::get('/anualprojections', [App\Http\Controllers\Reports\ReportsController::class, 'anualprojections'])->name('anualprojections');

Route::get('/bianualprojections', [App\Http\Controllers\Reports\ReportsController::class, 'bianualprojections'])->name('bianualprojections');

Route::get('/quaterlyprojections', [App\Http\Controllers\Reports\ReportsController::class, 'quaterlyprojections'])->name('quaterlyprojections');

Route::get('/ledgers', [App\Http\Controllers\Reports\ReportsController::class, 'ledgers'])->name('ledgers');

        });
    });
});



Auth::routes();
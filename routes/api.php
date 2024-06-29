<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [App\Http\Controllers\admin\UsersController::class, 'login']);
Route::post('register', [App\Http\Controllers\admin\UsersController::class, 'register']);
Route::post('logout', [App\Http\Controllers\admin\UsersController::class, 'logout']);
Route::post('/app/register', [App\Http\Controllers\admin\UsersController::class, 'sync_users']);
Route::post('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'forgot']);
Route::post('/password/submit', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'reset']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [App\Http\Controllers\admin\UsersController::class, 'logout']);
    Route::get('/imageuploader', [App\Http\Controllers\ImageUploadController::class, 'index'])->name('api.imageuploader');
    Route::post('imageupload', [App\Http\Controllers\ImageUploadController::class, 'upload'])->name('api.imageupload');

});

Route::
        namespace('admin')->middleware(['auth:api'])->group(function () {
            Route::prefix('admin')->group(function () {
                Route::name('admin.')->group(function () {

                    Route::get('/users', [App\Http\Controllers\admin\UsersController::class, 'index'])->name('api.users.list');
                    Route::get('users/create/prefill', [App\Http\Controllers\admin\UsersController::class, 'create'])->name('api.users.create');
                    Route::post('/changepassword', [App\Http\Controllers\admin\UsersController::class, 'changepasswordSubmit'])->name('api.user.changepasswordSubmit');

                    Route::get('/settings', [App\Http\Controllers\admin\SettingsController::class, 'index'])->name('api.settings.list');
                    Route::get('/basecurrency/create/prefill', [App\Http\Controllers\admin\SettingsController::class, 'basecurrency'])->name('api.basecurrency.create');

                    Route::POST('/basecurrencysubmit', [App\Http\Controllers\admin\SettingsController::class, 'basecurrencysubmit'])->name('api.basecurrency.submit');

                });
            });
        });

Route::
        namespace('hr')->middleware(['auth:api'])->group(function () {
            Route::prefix('hr')->group(function () {
                Route::name('hr.')->group(function () {

                    Route::get('/employees', [App\Http\Controllers\hr\EmployeesController::class, 'index'])->name('api.employees.list');
                    Route::get('/employees/{id}/update_avatar/', [App\Http\Controllers\hr\EmployeesController::class, 'update_avatar'])->name('api.employees.update_avatar');

                    Route::post('/employees/update_avatarSubmit', [App\Http\Controllers\hr\EmployeesController::class, 'update_avatarSubmit'])
                        ->name('api.employees.update_avatarSubmit');

                });
            });
        });
Route::
        namespace('crm')->middleware(['auth:api'])->group(function () {
            Route::prefix('crm')->group(function () {
                Route::name('crm.')->group(function () {

                    Route::get('clients', [App\Http\Controllers\crm\ClientsController::class, 'index'])->name('api.employees.list');
                    Route::get('clients/create/prefill', [App\Http\Controllers\crm\ClientsController::class, 'create'])->name('api.employees.create');
                    Route::post('clients', [App\Http\Controllers\crm\ClientsController::class, 'store'])->name('api.employees.store');
                    Route::put('clients', [App\Http\Controllers\crm\ClientsController::class, 'update'])->name('api.employees.update');

                });
            });
        });


Route::
        namespace('main')->middleware(['auth:api'])->group(function () {
            Route::prefix('main')->group(function () {
                Route::name('main.')->group(function () {

                    Route::get('/documents/{id}/filetype/{filetype}', [App\Http\Controllers\main\Documentscontroller::class, 'index'])
                        ->name('api.documents.list');
                    Route::get('/gallery/{id}/filetype/{filetype}', [App\Http\Controllers\main\Documentscontroller::class, 'gallery'])
                        ->name('api.documents.gallery');

                    Route::get('/adddocuments/{id}/filetype/{filetype}', [App\Http\Controllers\main\Documentscontroller::class, 'create'])
                        ->name('api.documents.add');

                    Route::get('/upload/{id}/filetype/{filetype}', [App\Http\Controllers\main\Documentscontroller::class, 'store'])
                        ->name('api.documents.upload');


                    Route::post('/upload', [App\Http\Controllers\main\Documentscontroller::class, 'storedocumentapi'])
                        ->name('api.upload');

                    Route::get('/documentspreview/{id}', [App\Http\Controllers\main\Documentscontroller::class, 'preview'])->name('api.documents.preview');

                    Route::get('/documentsdownload/{id}', [App\Http\Controllers\main\Documentscontroller::class, 'download'])->name('api.documents.download');

                    Route::post('/setfeaturedimage', [App\Http\Controllers\main\Documentscontroller::class, 'setfeaturedimage'])->name('api.documents.setfeaturedimage');

                });
            });
        });

Route::
        namespace('rent')->middleware(['auth:api'])->group(function () {
            Route::prefix('rent')->group(function () {
                Route::name('rent.')->group(function () {

                    Route::get('properties', [App\Http\Controllers\rent\PropertiesController::class, 'index'])->name('api.properties.list');
                    Route::get('properties/{id}', [App\Http\Controllers\rent\PropertiesController::class, 'show'])->name('api.properties.show');
                    Route::post('properties', [App\Http\Controllers\rent\PropertiesController::class, 'store'])->name('api.properties.store');
                    Route::put('properties/{id}', [App\Http\Controllers\rent\PropertiesController::class, 'update'])->name('api.properties.update');
                    Route::get('properties/create/prefill', [App\Http\Controllers\rent\PropertiesController::class, 'create']);


                    Route::post('floors', [App\Http\Controllers\rent\FloorsController::class, 'store'])->name('api.floors.store');
                    Route::get('floorsonproperty/{id}', [App\Http\Controllers\rent\FloorsController::class, 'floorsonproperty'])->name('api.floors.floorsonproperty');

                    Route::post('units', [App\Http\Controllers\rent\UnitsController::class, 'store'])->name('api.units.store');
                    Route::put('units/{id}', [App\Http\Controllers\rent\UnitsController::class, 'update'])->name('api.units.update');
                    Route::get('units/create/prefill/{id}', [App\Http\Controllers\rent\UnitsController::class, 'create'])->name('api.units.create');
                    Route::get('unitsonproperty/{id}', [App\Http\Controllers\rent\UnitsController::class, 'unitsonproperty'])->name('api.units.unitsonproperty');
                    Route::get('getunitdetails/{id}', [App\Http\Controllers\rent\UnitsController::class, 'getunitdetails'])->name('api.units.getunitdetails');
                    Route::delete('deleteunit/{id}', [App\Http\Controllers\rent\UnitsController::class, 'destroy'])->name('api.units.destroy');

                    Route::get('tenantunitsonproperty/{id}', [App\Http\Controllers\rent\TenantUnitsController::class, 'index'])->name('api.rent.tenantunitsonproperty');
                    Route::post('tenantunits', [App\Http\Controllers\rent\TenantUnitsController::class, 'store'])->name('api.tenantunits.store');
                    Route::get('tenantunits/{id}', [App\Http\Controllers\rent\TenantUnitsController::class, 'show'])->name('api.tenantunits.show');
                    Route::put('tenantunits/{id}', [App\Http\Controllers\rent\TenantUnitsController::class, 'update'])->name('api.tenantunits.update');
                    Route::delete('tenantunitdelete/{id}', [App\Http\Controllers\rent\TenantUnitsController::class, 'delete'])->name('api.tenantunits.delete');
                    Route::get('tenantunits/create/prefill/{id}', [App\Http\Controllers\rent\TenantUnitsController::class, 'create'])->name('api.rent.create');


                    Route::get('paymentslist/{id}/', [App\Http\Controllers\rent\PaymentsController::class, 'index'])->name('api.payments.index');
                    Route::post('payments', [App\Http\Controllers\rent\PaymentsController::class, 'store'])->name('api.payments.store');
                    Route::get('payments/{id}', [App\Http\Controllers\rent\PaymentsController::class, 'show'])->name('api.payments.show');
                    Route::get('payments/create/prefill/{id}', [App\Http\Controllers\rent\PaymentsController::class, 'create'])->name('api.payments.create');
                    Route::get('gettenantunitschedules/{id}', [App\Http\Controllers\rent\PaymentScheduleController::class, 'gettenantunitschedules'])->name('api.gettenantunitschedules');
                    Route::get('/paymentsprint/{id}/', [App\Http\Controllers\rent\PaymentsController::class, 'print'])->name('api.payments.print');
                    Route::delete('/paymentdelete/{id}/', [App\Http\Controllers\rent\PaymentsController::class, 'delete'])->name('api.payment.delete');

                    Route::get('/expenseslist/{id}/', [App\Http\Controllers\rent\ExpensesController::class, 'index'])->name('api.expenses.list');
                    Route::post('expenses', [App\Http\Controllers\rent\ExpensesController::class, 'store'])->name('api.expenses.store');
                    Route::get('/expensescreate/{id}/', [App\Http\Controllers\rent\ExpensesController::class, 'create'])->name('api.expenses.add');
                    Route::get('/expensesupload/{id}/', [App\Http\Controllers\rent\ExpensesController::class, 'upload'])->name('api.expenses.upload');

                });
            });
        });

Route::
        namespace('Reports')->middleware(['auth:api'])->group(function () {
            Route::prefix('reports')->group(function () {
                Route::name('reports.')->group(function () {

                    Route::get('/unpaidrentreport', [App\Http\Controllers\Reports\ReportsController::class, 'unpaidrent'])
                        ->name('api.unpaidrent');

                    Route::get('/paymentsreport', [App\Http\Controllers\Reports\ReportsController::class, 'payments'])
                        ->name('api.payments');

                    Route::get('/collectionsreport', [App\Http\Controllers\Reports\ReportsController::class, 'collections'])
                        ->name('api.collections');

                    Route::get('/overview', [App\Http\Controllers\Reports\ReportsController::class, 'overview'])
                        ->name('api.overview');

                    Route::get('/revenue', [App\Http\Controllers\Reports\ReportsController::class, 'revenue'])
                        ->name('api.revenue');

                    Route::get('/leasestatus', [App\Http\Controllers\Reports\ReportsController::class, 'leasestatus'])
                        ->name('api.leasestatus');

                });
            });
        });
        Route::namespace('Accounts')->middleware(['auth:api'])->group(function () {
            Route::prefix('accounts')->group(function () {
                Route::name('accounts.')->group(function () {

        // Route::resource('rates', CurrencyRatesController::class);
        // Route::resource('invoices', InvoiceController::class);
        Route::get('/invoices', [App\Http\Controllers\Accounts\InvoiceController::class, 'index'])->name('api.invoices.list');
        Route::post('/invoices', [App\Http\Controllers\Accounts\InvoiceController::class, 'store'])->name('api.invoices.store');
        Route::get('/invoices/{id}', [App\Http\Controllers\Accounts\InvoiceController::class, 'show'])->name('api.invoices.show');
        Route::get('/invoices/create/prefill', [App\Http\Controllers\Accounts\InvoiceController::class, 'create'])->name('api.invoices.prefill');


    });
});
});

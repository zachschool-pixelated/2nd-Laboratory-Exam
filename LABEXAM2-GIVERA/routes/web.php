<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiceItemController;
use App\Models\Order;
use App\Models\Payment;
use App\Models\RiceItem;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'riceCount' => RiceItem::count(),
        'orderCount' => Order::count(),
        'paidOrderCount' => Order::where('payment_status', 'Paid')->count(),
        'paymentCount' => Payment::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('rice-items', RiceItemController::class)->except('show');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/orders/{order}/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/orders/{order}/payments', [PaymentController::class, 'store'])->name('payments.store');
});

require __DIR__.'/auth.php';

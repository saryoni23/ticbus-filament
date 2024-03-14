<?php

use App\Http\Controllers\TiketController;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\CancelPage;
use App\Livewire\CartPage;
use App\Livewire\CategoriesPage;
use App\Livewire\CheckoutPage;
use App\Livewire\HomePage;
use App\Livewire\MyOrdersDetailPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\SuccessPage;
use App\Livewire\TiketDetailPage;
use App\Livewire\TiketPage;
use App\Livewire\TiketviewPage;
use Filament\Pages\Auth\Login;
use Illuminate\Support\Facades\Route;
use App\Livewire\Storetiket;
use App\Livewire\Tiket\TiketIndex;
use App\Livewire\Tiket\TiketView;

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

Route::get('/', HomePage::class);
Route::get('/tiket', TiketPage::class);
Route::get('/cart', CartPage::class);
Route::get('/tiket/{tiket}', TiketDetailPage::class);
Route::get('/checkout', CheckoutPage::class);
Route::get('/my-orders', MyOrdersPage::class);
Route::get('/my-orders/{order}', MyOrdersDetailPage::class);

Route::get('/login',    LoginPage::class);
Route::get('/register', RegisterPage::class);
Route::get('/forgot',   ForgotPasswordPage::class);
Route::get('/reset',    ResetPasswordPage::class);
Route::get('/success',  SuccessPage::class);
Route::get('/cancel',   CancelPage::class);
// Route::get('/tiket1',   TiketviewPage::class)->name('tiketview.index');
// Route::post('/tiket1',   TiketviewPage::class)->name('tiketview.index');
// Route::get('/storage',   Storetiket::class)->name('storage.index');
// Route::get('/tiket',    [Controller::class, 'tiket'])->name('Tiket');
Route::get('tiket',      TiketIndex::class  )->name('tiket');




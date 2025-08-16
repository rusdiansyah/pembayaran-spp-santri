<?php

use App\Livewire\Dashboard;
use App\Livewire\Favicon;
use App\Livewire\JenisTagihanList;
use App\Livewire\KelasList;
use App\Livewire\Login;
use App\Livewire\LogoHome;
use App\Livewire\LogoLogin;
use App\Livewire\LupaPassword;
use App\Livewire\PembayaranCreate;
use App\Livewire\PembayaranDetail;
use App\Livewire\PembayaranList;
use App\Livewire\PhotoUser;
use App\Livewire\Register;
use App\Livewire\Role;
use App\Livewire\SantriList;
use App\Livewire\Setting;
use App\Livewire\TagihanList;
use App\Livewire\TahunAjaranList;
use App\Livewire\User;
use App\Livewire\User\Dashboard as UserDashboard;
use App\Livewire\User\PembayaranCreate as UserPembayaranCreate;
use App\Livewire\User\PembayaranList as UserPembayaranList;
use App\Livewire\User\TagihanList as UserTagihanList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', Login::class)->middleware('guest')->name('login');
// Route::get('/register', Register::class)->middleware('guest')->name('register');
Route::get('/forgot-password', LupaPassword::class)->middleware('guest')->name('forgot-password');

Route::group(['middleware' => ['auth', 'checkrole:Admin']], function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::get('setting/identitas', Setting::class)->name('identitas');
    Route::get('setting/favicon', Favicon::class)->name('favicon');
    Route::get('setting/logo_login', LogoLogin::class)->name('logo_login');
    Route::get('setting/logo_home', LogoHome::class)->name('logo_home');

    Route::get('user/role', Role::class)->name('role');
    Route::get('user/user', User::class)->name('user');

    Route::get('config/tahunAjaranList', TahunAjaranList::class)->name('tahunAjaranList');
    Route::get('config/kelasList', KelasList::class)->name('kelasList');
    Route::get('config/jenisTagihanList', JenisTagihanList::class)->name('jenisTagihanList');

    Route::get('santriList', SantriList::class)->name('santriList');
    Route::get('tagihanList', TagihanList::class)->name('tagihanList');

    Route::get('pembayaran/List', PembayaranList::class)->name('pembayaranList');
    Route::get('pembayaran/Create', PembayaranCreate::class)->name('pembayaranCreate');
    Route::get('pembayaran/Detail', PembayaranDetail::class)->name('pembayaranDetail');
});

Route::group(['middleware' => ['auth', 'checkrole:Santri']], function () {
    Route::get('user/dashboard', UserDashboard::class)->name('user.dashboard');
    Route::get('user/tagihanList', UserTagihanList::class)->name('userTagihanList');
    Route::get('user/pembayaranList', UserPembayaranList::class)->name('userPembayaranList');
    Route::get('user/pembayaranCreate', UserPembayaranCreate::class)->name('userPembayaranCreate');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('photouser', PhotoUser::class)->name('photouser');

    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
    // Route::get('errorPage', ErrorPage::class);
});

<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\LaporController;
use App\Http\Controllers\user\ProfilController;
use App\Http\Controllers\user\RatingController;
use App\Http\Controllers\admin\KomentarController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\TanggapanController;
use App\Http\Controllers\admin\IzinPenelitianController;
use App\Http\Controllers\user\LaporController as UserLaporController;
use App\Http\Controllers\user\KomentarController as UserKomentarController;
use App\Http\Controllers\user\IzinPenelitianController as UserIzinPenelitianController;
use App\Http\Controllers\admin\PpidController as AdminPpidController;
use App\Http\Controllers\user\PpidController as UserPpidController;

Route::get('/', function () {
     return view('user.msekretariat');
 })->name('home');
 
Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login/post', [AuthController::class, 'loginProcess'])->name('login.post');
    Route::get('/registration', [AuthController::class, 'registration'])->name('user.registration');
    Route::post('user/registration/post', [AuthController::class, 'registrationProcess'])->name('user.registration.post');
});

Route::middleware(['auth:user,admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => 'auth:user'], function(){
    Route::get('/beranda', [AuthController::class, 'showmsekretariat'])->name('home2');
    // Route::get('/profil', [AuthController::class, 'showProfil'])->name('profil');

    Route::get('/form-izin-penelitian', [UserIzinPenelitianController::class, 'create'])->name('user.izin_penelitian.create');

    Route::post('/form-izin-penelitian', [UserIzinPenelitianController::class, 'store'])->name('user.izin_penelitian.store');

    Route::get('/form-ppid', [UserPpidController::class, 'create'])->name('user.ppid.create');
    Route::post('/form-ppid', [UserPpidController::class, 'store'])->name('user.ppid.store');


    Route::get('/pengaduan', [UserLaporController::class, 'index'])->name('user.pengaduan.index');
    Route::post('/user/pengaduan/store', [UserLaporController::class, 'store'])->name('user.pengaduan.store');
    Route::get('/pengaduan/{id}', [UserLaporController::class, 'show'])->name('user.pengaduan.show');
    Route::get('/get-subkategori', [UserLaporController::class, 'getSubkategori'])->name('get.subkategori');
    Route::get('/pengaduan/{id}/edit', [UserLaporController::class, 'edit'])->name('user.pengaduan.edit');
    // Route untuk menyimpan perubahan pengaduan
    Route::put('/pengaduan/{id}', [UserLaporController::class, 'update'])->name('user.pengaduan.update');
    // Route untuk menampilkan form konfirmasi hapus pengaduan
    Route::get('/pengaduan/{id}/delete', [UserLaporController::class, 'delete'])->name('user.pengaduan.delete');
    // Route untuk menghapus pengaduan
    Route::delete('/pengaduan/{id}', [UserLaporController::class, 'destroy'])->name('user.pengaduan.destroy');
    Route::post('/pengaduan/{id}/tutup', [UserLaporController::class, 'tutup'])->name('user.pengaduan.tutup');
    // Route untuk menyimpan balasan user
    Route::post('/pengaduan/{id}/komentar', [UserKomentarController::class, 'store'])->name('user.komentar.store');
    
    Route::prefix('/rating')->group(function() {
    Route::get('/rating/{id}', [RatingController::class, 'create'])->name('user.pengaduan.rating.create');
    Route::get('/rating/show/{id}', [RatingController::class, 'show'])->name('user.pengaduan.rating.show');
    });
    Route::get('/pengaduan/rating/{id}', [RatingController::class, 'create'])->name('user.pengaduan.rating.create');
    Route::post('/pengaduan/rating/{id}', [RatingController::class, 'store'])->name('user.pengaduan.rating.store');

    Route::post('/user/pengaduan/{id}/komentar', [UserKomentarController::class, 'store'])->name('user.komentar.store');
    Route::get('/user/komentar/{id}/edit', [UserKomentarController::class, 'edit'])->name('user.komentar.edit');
    Route::put('/user/komentar/{id}', [UserKomentarController::class, 'update'])->name('user.komentar.update');
    Route::delete('/user/komentar/{id}', [UserKomentarController::class, 'destroy'])->name('user.komentar.destroy');
    Route::put('/pengaduan/{id}/tutup', [UserLaporController::class, 'tutup'])->name('user.pengaduan.tutup');

    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
});

Route::group(['middleware' => 'auth:admin'], function(){
    Route::get('admin/registration', [AdminController::class, 'adminregist'])->name('admin.registration');
    Route::post('admin/registration/post', [AdminController::class, 'adminregistProcess'])->name('admin.registration.post');
    Route::get('/admin/akun_admin', [AdminController::class, 'index'])->name('admin.akun_admin');
    Route::delete('/admin/akun-admin/{id}', [AdminController::class, 'destroy'])->name('admin.akun_admin.delete');

    Route::get('/admin/akun_user', [AdminController::class, 'akunUser'])->name('admin.akun_user');
    Route::delete('/admin/akun_user/{id}', [AdminController::class, 'hapusUser'])->name('admin.akun_user.delete');
    
    Route::get('/admin/notifications', [AdminController::class, 'showNotifications'])->name('admin.notifications');
    Route::get('/admin//notifications/read-all', [AdminController::class, 'markAsRead'])->name('admin.notifications.read');
    Route::get('admin/home', [DashboardController::class, 'index'])->name('admin.home');
    Route::get('/admin/notifications/delete-read', [AdminController::class, 'deleteRead'])->name('admin.notifications.deleteRead');

    Route::get('admin/izin_penelitian', [IzinPenelitianController::class, 'index'])->name('admin.izin_penelitian');
    Route::get('admin/izin_penelitian/create', [IzinPenelitianController::class, 'create'])->name('admin.izin_penelitian.create');
    Route::post('admin/izin_penelitian', [IzinPenelitianController::class, 'store'])->name('admin.izin_penelitian.store');
    Route::get('admin/izin_penelitian/edit/{id}', [IzinPenelitianController::class, 'edit'])->name('admin.izin_penelitian.edit');
    Route::put('admin/izin_penelitian/edit/{id}', [IzinPenelitianController::class, 'update'])->name('admin.izin_penelitian.update');
    Route::delete('admin/izin_penelitian/delete/{id}', [IzinPenelitianController::class, 'destroy'])->name('admin.izin_penelitian.destroy');
    Route::get('admin/izin_penelitian/show/{id}', [IzinPenelitianController::class, 'show'])->name('admin.izin_penelitian.show');
    Route::get('admin/izin_penelitian/filter', [IzinPenelitianController::class, 'filter'])->name('admin.izin_penelitian.filter');
    Route::get('admin/izin_penelitian/pdf', [IzinPenelitianController::class, 'generatePDF'])->name('admin.izin_penelitian.pdf');
    Route::get('admin/izin_penelitian/excel/', [IzinPenelitianController::class, 'export'])->name('admin.izin_penelitian.excel');

    Route::get('admin/ppid', [AdminPpidController::class, 'index'])->name('admin.ppid.index');
    Route::get('admin/ppid/create', [AdminPpidController::class, 'create'])->name('admin.ppid.create');
    Route::post('admin/ppid/store', [AdminPpidController::class, 'store'])->name('admin.ppid.store');
    Route::get('admin/ppid/edit/{id}', [AdminPpidController::class, 'edit'])->name('admin.ppid.edit');
    Route::put('admin/ppid/edit/{id}', [AdminPpidController::class, 'update'])->name('admin.ppid.update');
    Route::delete('admin/ppid/delete/{id}', [AdminPpidController::class, 'destroy'])->name('admin.ppid.destroy');
    Route::get('admin/ppid/show/{id}', [AdminPpidController::class, 'show'])->name('admin.ppid.show');
    Route::get('admin/ppid/filter', [AdminPpidController::class, 'filter'])->name('admin.ppid.filter');
    Route::get('admin/ppid/pdf', [AdminPpidController::class, 'generatePDF'])->name('admin.ppid.pdf');
    Route::get('admin/ppid/excel', [AdminPpidController::class, 'export'])->name('admin.ppid.excel');

    Route::get('/lapor', [LaporController::class, 'index'])->name('admin.lapor.index');
    Route::get('/lapor/{id}', [LaporController::class, 'show'])->name('admin.lapor.show');
    Route::delete('/lapor/{id}', [LaporController::class, 'destroy'])->name('admin.lapor.destroy');
    Route::get('/admin/lapor/pdf', [LaporController::class, 'generatePDF'])->name('admin.lapor.pdf');
    Route::get('/admin/lapor/excel', [LaporController::class, 'exportExcel'])->name('admin.lapor.excel');
    Route::get('/admin/lapor/filter', [LaporController::class, 'filter'])->name('admin.lapor.filter');
    Route::get('/tanggapan/{kategori_id}', [LaporController::class, 'tanggapanByKategori'])->name('admin.tanggapan.kategori');
    Route::get('admin/lapor/{id}/edit', [LaporController::class, 'edit'])->name('admin.lapor.edit');
    Route::put('admin/lapor/{id}', [LaporController::class, 'update'])->name('admin.lapor.update');
    Route::get('/admin/lapor/kategori/{id}', [LaporController::class, 'laporByKategori'])->name('admin.lapor.kategori');


    Route::get('/tanggapan', [TanggapanController::class, 'index'])->name('admin.tanggapan.index');
    Route::post('/tanggapan/{id}', [TanggapanController::class, 'store'])->name('admin.tanggapan.store');
    Route::patch('lapor/{lapor}/updateStatus', [LaporController::class, 'updateStatus'])->name('admin.lapor.updateStatus');

    // Route untuk menampilkan laporan berdasarkan kategori
    Route::get('/tanggapan/kategori/{kategoriId}', [TanggapanController::class, 'byKategori'])
        ->name('admin.tanggapan.byKategori');

// Route lainnya (store, edit, update, destroy) tetap sama
    

    // Route untuk edit tanggapan
    Route::get('/admin/tanggapan/{id}/edit', [TanggapanController::class, 'edit'])->name('admin.tanggapan.edit');
    Route::put('/admin/tanggapan/{id}', [TanggapanController::class, 'update'])->name('admin.tanggapan.update');

    // Route untuk hapus tanggapan
    Route::delete('/admin/tanggapan/{id}', [TanggapanController::class, 'destroy'])->name('admin.tanggapan.destroy');

    Route::get('/tanggapan/{namaKategori?}', [TanggapanController::class, 'index'])->name('admin.tanggapan.index');

    Route::post('/admin/tanggapan/{id}/komentar', [KomentarController::class, 'store'])
    ->name('admin.komentar.store');
    Route::get('/{id}/edit', [KomentarController::class, 'edit'])->name('admin.komentar.edit');
    Route::put('/{id}', [KomentarController::class, 'update'])->name('admin.komentar.update');
    Route::delete('/{id}', [KomentarController::class, 'destroy'])->name('admin.komentar.destroy');

    Route::get('/dashboard', [LaporController::class, 'dashboard'])->name('admin.lapor.dashboard');

    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

    // Tambah Kategori
    Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/store', [KategoriController::class, 'store'])->name('kategori.store');

    // Edit Kategori
    Route::get('/edit/{kategori}', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/update/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/destroy/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');


    // Tambah Sub Kategori
    Route::get('/create-sub', [KategoriController::class, 'createSub'])->name('kategori.create.sub');
    Route::post('/store-sub', [KategoriController::class, 'storeSub'])->name('kategori.store.sub');

    // Edit Sub Kategori
    Route::get('/edit-sub/{subKategori}', [KategoriController::class, 'editSubKategori'])->name('kategori.edit.sub');
    Route::put('/kategori/update-gabungan/{kategori}', [KategoriController::class, 'updateGabungan'])->name('kategori.update.gabungan');


    Route::delete('/destroy-sub/{subKategori}', [KategoriController::class, 'destroySub'])->name('kategori.destroy.sub');

    Route::put('/update-gabungan/{kategori}', [KategoriController::class, 'updateGabungan'])->name('kategori.update.gabungan');

});





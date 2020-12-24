<?php

Route::get('/', [\App\Http\Controllers\PostinganController::class, 'index']);
Route::post('/postingan/cekKey', [\App\Http\Controllers\PostinganController::class, 'cekPostinganKey'])->name('cek.postingan');

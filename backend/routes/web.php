<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchemaController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Schema Management
Route::resource('schemas', SchemaController::class);

// Schema Actions (AJAX endpoints)
Route::prefix('schemas/{schema}')->name('schemas.')->group(function () {
    Route::get('preview', [SchemaController::class, 'preview'])->name('preview');
    Route::get('export', [SchemaController::class, 'export'])->name('export');
    Route::get('validate', [SchemaController::class, 'validate'])->name('validate');
    Route::get('test-google', [SchemaController::class, 'testWithGoogle'])->name('test-google');
    Route::post('fields/bulk', [SchemaController::class, 'bulkUpdateFields'])->name('fields.bulk');
});

// Schema Type Actions
Route::get('schema-types/{schemaType}/required-fields', [SchemaController::class, 'getRequiredFields'])->name('schema-types.required-fields');

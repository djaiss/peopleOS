<?php

use App\Http\Controllers\Api\Settings\EthnicityController;
use App\Http\Controllers\Api\Settings\GenderController;
use App\Http\Controllers\Api\Settings\MeController;
use App\Http\Controllers\Api\Settings\TemplateController;
use App\Http\Controllers\Api\Vaults\ChildController;
use App\Http\Controllers\Api\Vaults\CompanyController;
use App\Http\Controllers\Api\Vaults\ContactBackgroundInformationController;
use App\Http\Controllers\Api\Vaults\ContactController;
use App\Http\Controllers\Api\Vaults\ContactJobInformationController;
use App\Http\Controllers\Api\Vaults\ContactPhoneNumberController;
use App\Http\Controllers\Api\Vaults\JournalController;
use App\Http\Controllers\Api\Vaults\NoteController;
use App\Http\Controllers\Api\Vaults\PartnerController;
use App\Http\Controllers\Api\Vaults\VaultController;
use App\Http\Middleware\CheckVault;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function (): void {
});

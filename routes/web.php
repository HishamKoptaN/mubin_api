<?php

use App\Http\Controllers\Admin\CurrenciesController;
use App\Http\Controllers\Admin\DepositsController;
use App\Http\Controllers\Admin\InvoicesController;
use App\Http\Controllers\Admin\PlansController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\TasksController;
use App\Http\Controllers\Admin\TransfersController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\WithdrawsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Models\Chat;
use App\Models\Invoice;
use App\Models\Message;
use App\Models\Plan;
use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\YourController;


require __DIR__ . '/auth.php';

<?php

use Illuminate\Support\Facades\Route;

use App\Interfaces\Http\Controller\AuthenticationsController;
use App\Interfaces\Http\Controller\ConsultationsController;
use App\Interfaces\Http\Controller\InvitationsController;
use App\Interfaces\Http\Controller\ServiceBookingsController;
use App\Interfaces\Http\Controller\TransactionsController;
use App\Interfaces\Http\Controller\UserFilesController;
use App\Interfaces\Http\Controller\UsersController;
use App\Interfaces\Http\Controller\VeterinariansController;
use App\Interfaces\Http\Controller\VeterinarianRegistrationsController;
use App\Interfaces\Http\Controller\VeterinarianSchedulesController;
use App\Interfaces\Http\Controller\VeterinarianServicesController;
use App\Interfaces\Http\Controller\VeterinarianVerificationController;

Route::post('/transactions/hooks', [TransactionsController::class, 'midtransHooks']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/my', [AuthenticationsController::class, 'getMyAccount']);
    Route::patch('/users/my/password', [UsersController::class, 'changeUserPassword']);
    Route::put('/users/my/profile/', [UsersController::class, 'updateMyProfile']);
    Route::delete('/authentications', [AuthenticationsController::class, 'logout']);
    Route::post('/users/my/files', [UserFilesController::class, 'store']);
    Route::get('/users/my/files', [UserFilesController::class, 'index']);
    Route::delete('/users/my/files', [UserFilesController::class, 'delete']);
    Route::get('/users/my/files/{fileId}', [UserFilesController::class, 'getById']);
    Route::delete('/users/my/files/{fileId}', [UserFilesController::class, 'deleteById']);
    Route::get('/users/my/files', [UserFilesController::class, 'index']);
    Route::get('/transactions', [TransactionsController::class, 'getAll']);
    Route::get('/transactions/{id}', [TransactionsController::class, 'getById']);
    Route::get('/bookings', [ServiceBookingsController::class, 'getAll']);
    Route::post('/bookings/{bookingId}/cancellation', [ServiceBookingsController::class, 'cancel']);
    Route::get('/bookings/{bookingId}', [ServiceBookingsController::class, 'getById']);
    Route::get('/consultations', [ConsultationsController::class, 'getAll']);
    Route::get('/bookings/{bookingId}/consultations', [ConsultationsController::class, 'getByBookingId']);
    Route::get('/users/my/consultations', [ConsultationsController::class, 'getMy']);

    Route::middleware('ability:role-invited-user')->group(function () {
        Route::put('/registrations/veterinarians', [VeterinarianRegistrationsController::class, 'revise']);
        Route::post('/registrations/veterinarians', [VeterinarianRegistrationsController::class, 'create']);
    });
    Route::middleware('ability:role-veterinarian,role-admin,role-superadmin')->group(function () {
        Route::delete('/veterinarians/services/{serviceId}', [VeterinarianServicesController::class, 'delete']);
        Route::delete('/veterinarians/schedules/{scheduleId}', [VeterinarianSchedulesController::class, 'remove']);
    });
    Route::middleware('ability:role-veterinarian,role-invited-user')->group(function () {
        Route::get('/users/my/registrations', [VeterinarianRegistrationsController::class, 'getMy']);
    });

    Route::middleware('ability:role-veterinarian,role-basic')->group(function () {
        Route::post('/bookings/{bookingId}/consultation/attendee', [ConsultationsController::class, 'join']);
    });
    Route::middleware('ability:role-veterinarian')->group(function () {
        Route::post('/veterinarians/services', [VeterinarianServicesController::class, 'add']);
        Route::put('/veterinarians/services/{serviceId}', [VeterinarianServicesController::class, 'edit']);
        Route::post('/veterinarians/schedules', [VeterinarianSchedulesController::class, 'add']);
        Route::get('/users/my/schedules', [VeterinarianSchedulesController::class, 'getMy']);
        Route::get('/users/my/wallet', [VeterinariansController::class, 'getMyWallet']);
    });
    Route::middleware('ability:role-superadmin,role-admin')->group(function () {
        Route::get('/users/{id}', [UsersController::class, 'getUserById']);
        Route::delete('/users/{id}', [UsersController::class, 'deleteUser']);
        Route::put('/users/{id}', [UsersController::class, 'updateUser']);
        Route::get('/users/{userId}/registrations', [VeterinarianRegistrationsController::class, 'getByUserId']);
        Route::get('/users/{customerId}/consultations', [ConsultationsController::class, 'getByCustomerId']);
        Route::get('/users', [UsersController::class, 'getAllUsers']);
        Route::post('/invitations', [InvitationsController::class, 'create']);
        Route::get('/invitations', [InvitationsController::class, 'getAll']);
        Route::delete('/invitations/{id}', [InvitationsController::class, 'revoke']);
        Route::get('/registrations/veterinarians', [VeterinarianRegistrationsController::class, 'getAll']);
        Route::get('/registrations/veterinarians/{registrationId}', [VeterinarianRegistrationsController::class, 'getById']);
        Route::post('/registrations/veterinarians/{registrationId}/verification', [VeterinarianVerificationController::class, 'add']);
        Route::put('/registrations/veterinarians/{registrationId}/verification', [VeterinarianVerificationController::class, 'edit']);
        Route::post('/veterinarians/services/{serviceId}/approval', [VeterinarianServicesController::class, "approve"]);
        Route::post('/veterinarians/services/{serviceId}/suspension', [VeterinarianServicesController::class, "suspend"]);
        Route::delete('/veterinarians/services/{serviceId}/suspension', [VeterinarianServicesController::class, "unsuspend"]);
        Route::get('/veterinarians/{veterinarianId}/consultations', [ConsultationsController::class, "getByVeterinarianId"]);
        Route::post('/veterinarians/{veterinarianId}/suspension', [VeterinariansController::class, "suspend"]);
        Route::delete('/veterinarians/{veterinarianId}/suspension', [VeterinariansController::class, "unsuspend"]);
        Route::get('/users/{customerId}/transactions', [TransactionsController::class, 'getAllByCustomerId']);
    });
    Route::middleware('ability:role-basic')->group(function () {
        Route::get('/veterinarians/services/{id}/startTimes', [VeterinarianSchedulesController::class, 'getAvailableStartTimes']);
        Route::post('/veterinarians/{veterinarianId}/services/{serviceId}/bookings', [ServiceBookingsController::class, 'add']);
        Route::get('/bookings/{bookingId}/reschedule/startTimes', [VeterinarianSchedulesController::class, 'startTimesForReschedule']);
        Route::post('/bookings/{bookingId}/reschedule', [ServiceBookingsController::class, 'reschedule']);
        Route::get('/users/my/transactions', [TransactionsController::class, 'getMy']);
    });
});

Route::get('/invitations/{id}', [InvitationsController::class, 'get']);
Route::post('/users', [UsersController::class, 'addUser']);
Route::post('/authentications', [AuthenticationsController::class, 'login']);
Route::get('/veterinarians/services', [VeterinarianServicesController::class, 'getAll']);
Route::get('/veterinarians/services/{id}', [VeterinarianServicesController::class, 'getById']);
Route::get('/veterinarians/{id}', [VeterinariansController::class, 'getById']);
Route::get('/veterinarians/{id}/services', [VeterinarianServicesController::class, 'getByVeterinarianId']);
Route::get('/veterinarians', [VeterinariansController::class, 'get']);
Route::get('/user_files/{pathname}', [UserFilesController::class, 'getByPathname'])->where('pathname', '.*');

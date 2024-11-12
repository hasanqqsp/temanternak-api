<?php

namespace App\Infrastructure\Providers;

use App\Domain\Consultations\ConsultationRepository;
use App\Domain\Invitations\InvitationRepository;
use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\Transactions\TransactionRepository;
use App\Domain\UserFiles\UserFileRepository;
use App\Domain\Users\UserRepository;
use App\Domain\VeterinarianRegistrations\VeterinarianRegistrationRepository;
use App\Domain\Veterinarians\VeterinarianRepository;
use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;
use App\Domain\VeterinarianServices\VeterinarianServiceRepository;
use App\Domain\VeterinarianVerifications\VeterinarianVerificationRepository;
use App\Domain\Wallets\WalletLogRepository;
use App\Infrastructure\Repository\Eloquent\ConsultationRepositoryEloquent;
use App\Infrastructure\Repository\Eloquent\InvitationRepositoryEloquent;
use App\Infrastructure\Repository\Eloquent\ServiceBookingRepositoryEloquent;
use App\Infrastructure\Repository\Eloquent\TransactionRepositoryEloquent;
use App\Infrastructure\Repository\Eloquent\UserFileRepositoryEloquent;
use App\Infrastructure\Repository\Eloquent\UserRepositoryEloquent;
use App\Infrastructure\Repository\Eloquent\VeterinarianRegistrationRepositoryEloquent;
use App\Infrastructure\Repository\Eloquent\VeterinarianRepositoryEloquent;
use App\Infrastructure\Repository\Eloquent\VeterinarianScheduleRepositoryEloquent;
use App\Infrastructure\Repository\Eloquent\VeterinarianServiceRepositoryEloquent;
use App\Infrastructure\Repository\Eloquent\VeterinarianVerificationRepositoryEloquent;
use App\Infrastructure\Repository\Eloquent\WalletLogRepositoryEloquent;
use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind interfaces to implementations here
        $this->app->singleton(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->singleton(UserFileRepository::class, UserFileRepositoryEloquent::class);
        $this->app->singleton(InvitationRepository::class, InvitationRepositoryEloquent::class);
        $this->app->singleton(VeterinarianRegistrationRepository::class, VeterinarianRegistrationRepositoryEloquent::class);
        $this->app->singleton(VeterinarianVerificationRepository::class, VeterinarianVerificationRepositoryEloquent::class);
        $this->app->singleton(VeterinarianRepository::class, VeterinarianRepositoryEloquent::class);
        $this->app->singleton(VeterinarianServiceRepository::class, VeterinarianServiceRepositoryEloquent::class);
        $this->app->singleton(VeterinarianScheduleRepository::class, VeterinarianScheduleRepositoryEloquent::class);
        $this->app->singleton(ServiceBookingRepository::class, ServiceBookingRepositoryEloquent::class);
        $this->app->singleton(TransactionRepository::class, TransactionRepositoryEloquent::class);
        $this->app->singleton(ConsultationRepository::class, ConsultationRepositoryEloquent::class);
        $this->app->singleton(WalletLogRepository::class, WalletLogRepositoryEloquent::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

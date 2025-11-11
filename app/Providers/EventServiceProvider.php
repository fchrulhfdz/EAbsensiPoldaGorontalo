<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // Anda bisa menambahkan event custom di sini
        // 'App\Events\UserCheckedIn' => [
        //     'App\Listeners\SendCheckInNotification',
        // ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // Event untuk logging activity
        Event::listen('illuminate.log', function ($level, $message, $context) {
            // Log activity ke database atau file
            \Log::channel('attendance')->$level($message, $context);
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
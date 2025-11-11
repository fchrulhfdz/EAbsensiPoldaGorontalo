<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Only load broadcast routes if broadcasting is enabled
        if ($this->app->config->get('broadcasting.default') !== 'log') {
            Broadcast::routes();
        }

        // Only require channels.php if the file exists
        $channelsPath = base_path('routes/channels.php');
        if (file_exists($channelsPath)) {
            require $channelsPath;
        }
    }
}
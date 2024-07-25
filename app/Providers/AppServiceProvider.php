<?php

namespace App\Providers;

use Filament\Tables\Table;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Filament\Notifications\Notification;
use Illuminate\Queue\Events\JobProcessing;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Queue::before(function (JobProcessing $event) {
            Notification::make()
            ->title('GenerateProductCsvJob started')
            ->info()
            ->body('Job Payload'.count($event->job->payload()))
            ->send();
        });
        Table::$defaultNumberLocale = 'hu';
    }
}

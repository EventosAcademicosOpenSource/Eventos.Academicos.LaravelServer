<?php

namespace App\Providers;

use App\Event;
use App\Sponsor;
use App\Speaker;
use App\EventChildren;
use App\Observers\EventsObserver;
use App\Observers\SponsorObserver;
use App\Observers\SpeakerObserver;
use App\Observers\EventChildrenObserver;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        setlocale(LC_ALL, \Config::get('app.lc_all'));
        Carbon::setLocale(\Config::get('app.fallback_locale'));

        Schema::defaultStringLength(191);
        Event::observe(EventsObserver::class);
        Sponsor::observe(SponsorObserver::class);
        Speaker::observe(SpeakerObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

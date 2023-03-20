<?php

namespace App\Observers;


use App\Models\Package;

class PackageObserver
{
    /**
     * Handle the Pacakge "deleted" event.
     *
     * @param Package $package
     * @return void
     */
    public function created(Package $package)
    {
        cache()->forget('home-api');
    }

    /**
     * Handle the Pacakge "deleted" event.
     *
     * @param Package $package
     * @return void
     */
    public function updated(Package $package)
    {
        cache()->forget('home-api');
    }

    /**
     * Handle the Pacakge "deleted" event.
     *
     * @param Package $package
     * @return void
     */
    public function deleted(Package $package)
    {
        cache()->forget('home-api');
    }

    /**
     * Handle the Pacakge "deleted" event.
     *
     * @param Package $package
     * @return void
     */
    public function restored(Package $package)
    {
        cache()->forget('home-api');
    }

    /**
     * Handle the Pacakge "deleted" event.
     *
     * @param Package $package
     * @return void
     */
    public function forceDeleted(Package $package)
    {
        cache()->forget('home-api');
    }
}

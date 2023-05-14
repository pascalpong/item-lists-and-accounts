<?php

namespace App\Observers;

use App\Models\RandomList;

class RandomListObserver
{
    /**
     * Handle the RandomList "created" event.
     */
    public function created(RandomList $randomList): void
    {
        //
    }

    /**
     * Handle the RandomList "updated" event.
     */
    public function updated(RandomList $randomList): void
    {
        //
    }

    /**
     * Handle the RandomList "deleted" event.
     */
    public function deleted(RandomList $randomList): void
    {
        //
    }

    /**
     * Handle the RandomList "restored" event.
     */
    public function restored(RandomList $randomList): void
    {
        //
    }

    /**
     * Handle the RandomList "force deleted" event.
     */
    public function forceDeleted(RandomList $randomList): void
    {
        //
    }
}

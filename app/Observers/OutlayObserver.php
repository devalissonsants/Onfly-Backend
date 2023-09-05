<?php

namespace App\Observers;

use App\Events\OutlayNotificationUser;
use App\Models\Outlay;
use App\Models\User;

class OutlayObserver
{
    public function created(Outlay $outlay): void
    {
        event(new OutlayNotificationUser(User::find($outlay->user_id)));
    }

    public function updated(Outlay $outlay): void
    {
        if ($outlay->isDirty('user_id')) {
            event(new OutlayNotificationUser(User::find($outlay->user_id)));
        }
    }

    public function deleted(Outlay $outlay): void
    {
        //
    }

    public function restored(Outlay $outlay): void
    {
        //
    }

    public function forceDeleted(Outlay $outlay): void
    {
        //
    }
}

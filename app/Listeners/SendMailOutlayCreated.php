<?php

namespace App\Listeners;

use App\Events\OutlayNotificationUser;
use App\Mail\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailOutlayCreated
{
    public function handle(OutlayNotificationUser $event): void
    {
        Mail::to($event->user->email)->send(new SendMail([
            'title' => 'E-mail de confirmação',
            'body' => 'Despesa cadastrada para seu usuário.'
        ]));
    }
}

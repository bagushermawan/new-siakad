<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserLoggedInListener implements ShouldQueue
{

    public function __construct()
    {
        //
    }

    public function handle(UserLoggedIn $event)
    {
        // Tambahkan logika "last login" di sini
        $event->user->update(['last_login' => now()]);
    }
}

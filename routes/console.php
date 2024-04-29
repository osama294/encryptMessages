<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Message;

Artisan::command('delete:expired-message', function () {
    $messages = Message::where('expires_at', '<', now())
        ->get();
    foreach ($messages as $message) {
        $message->delete();
    }
})->purpose('Delete expired messages')->everyMinute();

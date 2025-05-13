<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewPropertyNotification extends Notification
{
    use Queueable;

    public $property;

    public function __construct($property)
    {
        $this->property = $property;
    }

    public function via($notifiable)
    {
        return ['database']; // نخزن الإشعار
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Nouvelle propriété ajoutée',
            'user_name' => auth()->user()->name, 
            'message' => $this->data['message'],
            'property_id' => $this->property->id,
            'action' => 'a ajouté une propriété',
            'timestamp' => now()->toDateTimeString(),
        ];
    }

}

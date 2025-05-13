<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GenericNotification extends Notification
{
    use Queueable;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return $this->data;
    }
    public function toArray($notifiable)
    {
        return [
            'title' => $this->data['title'],
            'user_name' => $this->data['user_name'],
            'message' => $this->data['message'],
            'action' => $this->data['action'],
            'timestamp' => $this->data['timestamp'],
        ];
    }



}

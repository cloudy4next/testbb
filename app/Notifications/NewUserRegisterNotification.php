<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class NewUserRegisterNotification extends Notification
{
    use Queueable;
    public $data;
    public $type;
    public $module;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $type, $module)
    {
        //
        $this->data = $data;
        $this->type = $type;
        $this->module = $module;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $userName = User::where('id', $this->data->user_id)->pluck('name');
        // dd($userName[0]);
        return [
            'title' => $this->data->title,
            'module' => $this->module,
            'type' => $this->type,
            'userName' => $userName[0],
        ];
    }
}

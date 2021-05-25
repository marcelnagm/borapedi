<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MessageNotification extends Notification
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database','broadcast'];
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
            ->greeting(__('Hello ').$this->user->name)
            ->subject(__('This is a test email from ').config('app.name'))
            ->action(__('Visit').' '.config('app.name'), url(config('app.url')))
            ->line(__('We are happy that email works now.'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
     public function toArray($notifiable)
    {   
        $greeting = __('There is new order');
            $line = __('You have just received an order');
       
        return [
            'title'=>$greeting,
            'body' =>$line,
        ];
    }
     public function toDatabase($notifiable)
    {     //Created
            $greeting = __('There is new order');
            $line = __('You have just received an order');
       
        return [
            'title'=>$greeting,
            'body' =>$line,
        ];
    }
}

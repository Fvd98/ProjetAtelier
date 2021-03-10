<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AtelierNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->greeting('Bonjour,')         
            ->subject('Une place est s\'est libérée pour un atelier')
            ->line('Ceci est une notification vous informant qu\'une place s\'est libérée pour un atelier de la Semaine des Sciences humaines du Cégep de l\'Outaouais pour lequel vous avez demandé à être notifié.  
            Vite! allez vous inscrire avant que cette place soit prise.  
              
            Premier arrivé, premier servi.')  
            ->line('Merci!')
            ->salutation('Nos salutations,  
            Inscription aux ateliers.');  
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolicitudRechazadaNotification extends Notification
{
    use Queueable;
    protected $sol_id;
    protected $sol_motivo;
    protected $libroSol_nombre;

    /**
     * Create a new notification instance.
     */
    public function __construct($sol_id, $sol_motivo, $libroSol_nombre)
    {
        $this->sol_id = $sol_id;
        $this->sol_motivo = $sol_motivo;
        $this->libroSol_nombre = $libroSol_nombre;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable){
        return [
            'solicitud_id' => $this->sol_id,
            'solicitud_motivo' => $this->sol_motivo,
            'libroSol_nombre' => $this->libroSol_nombre,
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

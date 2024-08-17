<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PrestamoCanceladoNotification extends Notification
{
    use Queueable;
    
    protected $libroPre_nombre;
    protected $alumno;

    public function __construct( $libroPre_nombre, $alumno)
    {
        $this->libroPre_nombre = $libroPre_nombre;
        $this->alumno = $alumno;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable){
        return [
            'alumno_nombre' => $this->alumno->alu_nombre,
            'libroPre_nombre' => $this->libroPre_nombre,
            // Otros datos que desees guardar en la notificación
            // 'titulo_libro' => $this->solicitud->libro->titulo,
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

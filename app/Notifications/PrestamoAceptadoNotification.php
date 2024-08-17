<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PrestamoAceptadoNotification extends Notification
{
    use Queueable;
    protected $prestamo;
    protected $alumno;
    protected $libroPre_nombre;

    /**
     * Create a new notification instance.
     */
    public function __construct($prestamo, $libroPre_nombre, $alumno)
    {
        $this->prestamo = $prestamo;
        $this->libroPre_nombre = $libroPre_nombre;
        $this->alumno = $alumno;
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
            'alumno_nombre' => $this->alumno->alu_nombre,
            'prestamo_fechaInicio' => $this->prestamo->fechaInicio,
            'prestamo_fechaFinal' => $this->prestamo->fechaFinal,
            'prestamo_horaInicio' => $this->prestamo->horaInicio,
            'prestamo_horaFinal' => $this->prestamo->horaFinal,
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

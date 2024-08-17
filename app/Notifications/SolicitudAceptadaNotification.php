<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolicitudAceptadaNotification extends Notification
{
    use Queueable;
    protected $datosSolicitud;
    protected $libroPre_nombre;

    /**
     * Create a new notification instance.
     */
    public function __construct($datosSolicitud, $libroPre_nombre)
    {
        $this->datosSolicitud = $datosSolicitud;
        $this->libroPre_nombre = $libroPre_nombre;
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
            'solicitud_id' => $this->datosSolicitud->solicitud_sol_id,
            'solicitud_alumno' => $this->datosSolicitud->alumnos_id,
            'solicitud_libro' => $this->datosSolicitud->libros_lib_id,
            'prestamo_fechaInicio' => $this->datosSolicitud->fechaInicio,
            'prestamo_fechaFinal' => $this->datosSolicitud->fechaFinal,
            'prestamo_horaInicio' => $this->datosSolicitud->horaInicio,
            'prestamo_horaFinal' => $this->datosSolicitud->horaFinal,
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

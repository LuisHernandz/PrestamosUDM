<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolicitudEnviadaNotification extends Notification
{
    use Queueable;
    protected $datosSolicitud;
    /**
     * Create a new notification instance.
     */
    public function __construct($datosSolicitud)
    {
        $this->datosSolicitud = $datosSolicitud;
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
            'solicitud_id' => $this->datosSolicitud->sol_id,
            'solicitud_fecha' => $this->datosSolicitud->created_at,
            'solicitud_alumno' => $this->datosSolicitud->alumnos_id,
            'solicitud_alumno_matricula' => $this->datosSolicitud->alu_matricula,
            'solicitud_alumno_nombre' => $this->datosSolicitud->alu_nombre,
            'solicitud_alumno_apellidos' => $this->datosSolicitud->alu_apellidos,
            'solicitud_alumno_genero' => $this->datosSolicitud->generos_gen_id,
            'solicitud_alumno_apellidos' => $this->datosSolicitud->alu_apellidos,
            'solicitud_libro' => $this->datosSolicitud->libros_lib_id,
            'solicitud_libro_titulo' => $this->datosSolicitud->lib_titulo,            
            'solicitud_libro_descripcion' => $this->datosSolicitud->lib_descripcion,
            'solicitud_libro_autor' => $this->datosSolicitud->aut_nombre,
            'solicitud_libro_carrera' => $this->datosSolicitud->car_nombre,
            'solicitud_libro_nivel' => $this->datosSolicitud->niv_nombre,
            'solicitud_fecha' => $this->datosSolicitud->created_at,
            'solicitud_estado' => $this->datosSolicitud->sol_estado,

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
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use DB;

class Comment extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment)
    {
        $this->file_Id = $comment['file_Id'];
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
    public function toDatabase($notifiable)
    {
        $file = DB::table('files')
            ->where('file_Id', $this->file_Id)
            ->first();
            
        if($file->event_Id != NULL){
            $event = DB::table('events')
                ->where('event_Id', $file->event_Id)
                ->first();
            
            return [
                'message'=>"Someone has commented a photo ('".$file->file_Description."') you commented on the event '".$event->event_Name.".'",
                'url'=>url('/events/'. $file->event_Id.'#img-'.$file->file_Id)
            ];
        }else{
            $album = DB::table('albums')
                ->where('album_Id', $file->album_Id)
                ->first();
                
            return [
                'message'=>"Someone has commented a photo ('".$file->file_Description."') you commented on the album '".$album->album_Name.".'",
                'url'=>url('/album/'. $file->album_Id)
            ]; 
        }
    }
}

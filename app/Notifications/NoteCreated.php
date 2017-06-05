<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Log;

class NoteCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($loop)
    {
        $this->loop = $loop;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }


    public function toSlack($notifiable)
    {
        Log::info($this->loop);
        $loop = $this->loop;
        $url = "http://sil-loops.herokuapp.com/loops/".$this->loop->id;
        return (new SlackMessage)
                    ->from("Loops")
                    ->to('#sil-loops')
                    ->image('http://images4.static-bluray.com/reviews/902_1.jpg')
                    ->content('Note Created: '.$loop->project->name.' - '.$loop->name)
                    ->attachment(function ($attachment) use ($url,$loop) {
                      $attachment->title($loop->name, $url)
                          ->markdown(['fields'])
                          ->fields([
                            'Description'=>$loop->newest_note->body
                          ]);
                    });
    }
}

<?php

namespace App\Notifications;

use Log;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class ProjectCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($project)
    {
        $this->project = $project;
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
        Log::info($this->project);
        $project = $this->project;
        $url = 'http://sil-loops.herokuapp.com/projects/'.$this->project->id;

        return (new SlackMessage)
                    ->from('Loops')
                    ->to('#sil-loops')
                    ->image('http://images4.static-bluray.com/reviews/902_1.jpg')
                    ->content('Project Created: '.$project->name)
                    ->attachment(function ($attachment) use ($url, $project) {
                        $attachment->title($project->name, $url)
                          ->markdown(['fields'])
                          ->fields([
                            'Description'=>$project->latest_note->body,
                          ]);
                    });
    }
}

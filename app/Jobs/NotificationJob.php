<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\NewCompanyRegistration;
use Notification;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email="";
    protected $name="";
    /**
     * Create a new job instance.
     */
    public function __construct($email,$name)
    {
        $this->email=$email;
        $this->name=$name;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notification::route('mail', $this->email)->notify(new NewCompanyRegistration($this->name));
    }
}

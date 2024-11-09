<?php

namespace App\Console\Commands;

use App\Mail\TestEmailNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email {email}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        Mail::to($email)->send(mailable: new TestEmailNotification());
        $this->info("Email successfully sent to {$email}");
    }
}

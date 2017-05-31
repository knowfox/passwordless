<?php

namespace Knowfox\Passwordless\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendRegisterMail implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;

        Mail::send('passwordless::email-getting-started', [
            'user' => $user,
        ], function ($m) use ($user) {
            $m->from('hello@' . env('MAIL_DOMAIN'), config('app.name'));
            $m->to($user->email, $user->name)->subject('Hello ' . $user->name . ', get started with ' . config('app.name') . '!');
        });
    }
}

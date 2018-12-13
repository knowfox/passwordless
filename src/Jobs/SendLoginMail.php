<?php

namespace Knowfox\Passwordless\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendLoginMail implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    private $user;
    private $url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        $url = $this->url;

        Mail::send('passwordless::email.login', [
            'user' => $user,
            'url' => $url,
        ], function ($m) use ($user) {
            $m->from('hello@' . env('MAIL_DOMAIN'), config('app.name'));
            $m->to($user->email)->subject(
                __('passwordless::email.login_subject', [
                    'user' => $user->name,
                    'app' => config('app.name')
                ])
            );
        });
    }
}

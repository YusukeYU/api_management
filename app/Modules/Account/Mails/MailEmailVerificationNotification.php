<?php

namespace App\Modules\Account\Mails;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class MailEmailVerificationNotification extends VerifyEmail
{
    use Queueable;

    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $token = Str::random(255);

        $now = Carbon::now()->toDateTimeString();
        $expires = Carbon::now()->addHour(1)->toDateTimeString();

        $queryBuilder = DB::table('email_checks');

       $queryBuilder->where('email', $notifiable->email)->delete();

        $data = [
            'email' => $notifiable->email,
            'token' => $token,
            'created_at' => $now,
            'expires_at' => $expires
        ];

        $queryBuilder->insert($data);

//        definir url web
        $url = url(('web') . '/reset-password/' . $token) .
            '?email=' . urlencode($notifiable->email);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }

        return (new MailMessage)
            ->from('gabrielforg1ven2222@gmail.com', 'Teste')
            ->subject('Teste verificação de e-mail')
            ->view('Account::Emails.sendMailResetPasswordNotification', [
                'token' => $token,
                'user' => $notifiable,
                'url' => $url,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

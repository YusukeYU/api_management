<?php

namespace App\Modules\Account\Mails;

use Illuminate\Mail\Mailable;

class MailVerificationEmail extends Mailable
{

    protected $values;

    public function __construct($values)
    {
        $this->values = $values;
    }

    public function build()
    {
        return $this->from('gabrielforg1ven2222@gmail.com')
            ->view('Account::Emails.sendMailResetPasswordNotification', [
                'token' => $this->values['token'],
                'user' => $this->values['user'],
                'url' => 'http://api_m/register',
            ]);
    }
}

<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class Mailer
{

    public function __construct(
        private MailerInterface $mailer
    )
    {
        // ...
    }

    public function send($to, $subject, $template = null, $context = [])
    {
        // Send email
        $email = new TemplatedEmail();
        $email->to($to)
            ->subject($subject)
            ->context($context);

        if ($template) {
            $email->htmlTemplate($template);
        } else {
            $email->text('This is a test email');
        }

        $this->mailer->send($email);


    }
}

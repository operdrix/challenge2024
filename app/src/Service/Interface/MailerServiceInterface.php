<?php

namespace App\Service\Interface;

use App\Enum\MailTypeEnum;

interface MailerServiceInterface
{
    /**
     * Send email based on MailType 
     */
    public function sendMail(MailTypeEnum $mailType, string $cc);
}

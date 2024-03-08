<?php

namespace App\Service;

use App\Constant\AppConstant;
use App\Enum\MailTypeEnum;
use App\Service\Interface\MailerServiceInterface;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailerService implements MailerServiceInterface
{
    public function __construct(
        private MailerInterface $mailer
    ) {
    }

    public function sendMail(MailTypeEnum $mailType, string $cc)
    {
        match ($mailType) {
            MailTypeEnum::STUDENT_REGISTER => $this->sendStudentRegisterMail($cc),
            MailTypeEnum::STUDENT_INSCRIPTION => $this->sendStudentInscriptionMail($cc),
            MailTypeEnum::GRADE_INSCRIPTION => $this->sendGradeInscriptionMail($cc),
            MailTypeEnum::STUDENT_QUIZ => $this->sendStudentQuizMail($cc)
        };
    }

    private function sendStudentRegisterMail(string $cc)
    {
        $email = (new TemplatedEmail())
            ->from(AppConstant::APP_MAIL)
            ->to($cc)
            ->subject("EduMentor - Inscription à la plateforme")
            ->htmlTemplate('emails/student_register.html.twig')
            ->locale('fr')
            ->context([]);
        try {

            $this->mailer->send($email);
        } catch (Exception $e) {
            dd($e);
        }
    }

    private function sendStudentInscriptionMail($cc)
    {
    }

    private function sendGradeInscriptionMail($cc)
    {
    }

    private function sendStudentQuizMail($cc)
    {
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PresentationScheduleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailBody;
    public $datetime;
    public $assessmentType;

    public $attachmentPaths;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($mailBody, $datetime, $assessmentType, $attachmentPaths)
    {
        $this->mailBody = $mailBody;
        $this->datetime = $datetime;
        $this->assessmentType = $assessmentType;
        $this->attachmentPaths = $attachmentPaths;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from = env('MAIL_FROM_ADDRESS', '21bmiit145@gmail.com');

        $date = date_create($this->datetime);
        $dateOnly = date_format($date, 'Y-m-d');
        $timeOnly = date_format($date, 'h:i A');

        $mail = $this->subject("$this->assessmentType Schedule on $dateOnly at $timeOnly")
            ->from("$from", 'PMS Committee');
//            ->replyTo('21bmiit145@gmail.com', 'PMS Committee')

        foreach ($this->attachmentPaths as $attachmentPath) {
            $mail->attach($attachmentPath);
        }
//        $mail->attach(public_path('attachments/5980_1.pdf'));
        $mail->view('mail.presentationScheduleMail')
            ->with([
                'mailBody' => $this->mailBody,
                'dateOnly' => $dateOnly,
                'timeOnly' => $timeOnly,
                'assessmentType' => $this->assessmentType
            ]);

        return $mail;

    }
}

?>

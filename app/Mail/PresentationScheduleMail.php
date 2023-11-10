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

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($mailBody, $datetime, $assessmentType)
    {
        $this->mailBody = $mailBody;
        $this->datetime = $datetime;
        $this->assessmentType = $assessmentType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = date_create($this->datetime);
        $dateOnly = date_format($date, 'Y-m-d');
        $timeOnly = date_format($date, 'h:i A');

        return $this->subject("$this->assessmentType Schedule on $dateOnly at $timeOnly")
            ->name('PMS Committee')
//            ->replyTo('21bmiit145@gmail.com', 'PMS Committee')
            ->view('mail.presentationScheduleMail')
            ->with([
                'mailBody' => $this->mailBody,
                'dateOnly' => $dateOnly,
                'timeOnly' => $timeOnly,
                'assessmentType' => $this->assessmentType
            ]);
    }
}

?>

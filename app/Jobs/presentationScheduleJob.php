<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Mail\PresentationScheduleMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class presentationScheduleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $emails;
    public $emailBody;
    public $datetime;
    public $assessmentType;
    public  $attachmentPaths;

    public function __construct($emails, $emailBody, $datetime, $assessmentType , $attachmentPaths)
    {
        $this->emails = $emails;
        $this->emailBody = $emailBody;
        $this->datetime = $datetime;
        $this->assessmentType = $assessmentType;
        $this->attachmentPaths = $attachmentPaths;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // for invalid mail as not found mail  , log it
        foreach ($this->emails as $email) {
            try {
                Mail::to($email)->queue(new PresentationScheduleMail($this->emailBody, $this->datetime, $this->assessmentType ,  $this->attachmentPaths));
            } catch (\Exception $e) {
                Log::error("Error in sending mail to " . $email . " " . $e->getMessage());
            }
        }
    }
}

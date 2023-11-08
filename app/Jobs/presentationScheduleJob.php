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
    public $email;
    public function __construct($email)
    {
    $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            // for invalid mail as not found mail  , log it
        try {
            Mail::to($this->email)->queue(new PresentationScheduleMail("schedule"));
        }catch(\Exception $e){
            Log::error("Error in sending mail to ".$this->email." ".$e->getMessage());
        }

    }
}

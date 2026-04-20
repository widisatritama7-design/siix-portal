<?php

namespace App\Mail\MTC;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyCheckReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $shift;
    public $date;
    public $data;
    public $timeRange;

    public function __construct($shift, $date, $data)
    {
        $this->shift = $shift;
        $this->date = $date;
        $this->data = $data;

        $shiftTimes = [
            1 => '07:00 - 09:00',
            2 => '15:00 - 17:00',
            3 => '23:00 - 01:00',
        ];

        $this->timeRange = $shiftTimes[$this->shift] ?? '';
    }

    public function build()
    {
        return $this->subject("Daily Check Report - Shift {$this->shift} - {$this->date->format('Y-m-d')}")
            ->view('emails.mtc.daily-check-report')
            ->with([
                'shift' => $this->shift,
                'date' => $this->date,
                'data' => $this->data,
                'timeRange' => $this->timeRange,
            ]);
    }
}

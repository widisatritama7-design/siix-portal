<?php

namespace App\Mail\HR;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\HR\ComelateEmployee;
use Illuminate\Queue\SerializesModels;

class ComelateCreated extends Mailable
{
    use Queueable, SerializesModels;

    public ComelateEmployee $comelate;
    public string $hod_name;

    public function __construct(ComelateEmployee $comelate, string $hod_name)
    {
        $this->comelate = $comelate;
        $this->hod_name = $hod_name;
    }

    public function build()
    {
        return $this
            ->subject('New Comelate Entry')
            ->view('emails.hr.comelate')
            ->with([
                'comelate' => $this->comelate,
                'hod_name' => $this->hod_name,
                'is_hod' => !empty($this->hod_name)  // True jika ada nama HOD
            ]);
    }
}
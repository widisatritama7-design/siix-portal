<?php

namespace App\Mail\PROD;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KaizenUpdatesEmail extends Mailable
{
    use SerializesModels;

    public $kaizenCount;
    public $url;
    public $chartImageUrl;
    public $rankChartImageUrl;

    public function __construct(int $kaizenCount, string $url, string $chartImageUrl, string $rankChartImageUrl)
    {
        $this->kaizenCount = $kaizenCount;
        $this->url = $url;
        $this->chartImageUrl = $chartImageUrl;
        $this->rankChartImageUrl = $rankChartImageUrl;
    }

    public function build()
    {
        return $this->view('emails.prod.kaizen_updates')
                    ->subject('Kaizen Updates This Week')
                    ->with([
                        'kaizenCount' => $this->kaizenCount,
                        'url' => $this->url,
                        'chartImageUrl' => $this->chartImageUrl,
                        'rankChartImageUrl' => $this->rankChartImageUrl,
                    ]);
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Mydnic\Volet\Features\FeatureManager;
use Mydnic\Volet\Features\FeedbackMessages;

class VoletServiceProvider extends ServiceProvider
{
    public function boot(FeatureManager $volet): void
    {
        $this->registerFiturMasukan($volet);
    }

    private function registerFiturMasukan(FeatureManager $volet): void
    {
        $volet->register(
            (new FeedbackMessages)
                // Tampilan utama fitur
                ->setLabel('Masukan & Saran')
                ->setIcon(
                    'https://api.iconify.design/lucide:messages-square.svg?color=%234f46e5'
                )

                // Kategori masukan
                ->addCategory(
                    slug: 'bug',
                    name: 'Laporan Bug',
                    icon: 'https://api.iconify.design/lucide:bug.svg?color=%23ef4444'
                )
                ->addCategory(
                    slug: 'improvement',
                    name: 'Permintaan Fitur',
                    icon: 'https://api.iconify.design/lucide:sparkles.svg?color=%23f59e0b'
                )
                ->addCategory(
                    slug: 'general',
                    name: 'Masukan Umum',
                    icon: 'https://api.iconify.design/lucide:message-circle.svg?color=%2306b6d4'
                )
        );
    }
}
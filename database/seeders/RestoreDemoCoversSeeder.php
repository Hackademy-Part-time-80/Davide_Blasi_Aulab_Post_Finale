<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class RestoreDemoCoversSeeder extends Seeder
{
    public function run(): void
    {
        $covers = [
            'demo-ai-in-redazione.svg' => 'Intelligenza artificiale',
            'demo-uffici-remoto.svg' => 'Lavoro da remoto',
            'demo-tetti-verdi.svg' => 'Città più verdi',
            'demo-librerie-indipendenti.svg' => 'Librerie indipendenti',
            'demo-telescopi-nuova-generazione.svg' => 'Esplorare lo spazio',
            'demo-dormire-bene.svg' => 'Dormire bene',
            'demo-viaggiare-lento.svg' => 'Viaggiare lento',
            'demo-allenarsi-con-metodo.svg' => 'Allenarsi con metodo',
            'demo-cybersicurezza-basi.svg' => 'Cybersicurezza',
            'demo-startup-sostenibili.svg' => 'Startup sostenibili',
            'demo-cinema-sala-streaming.svg' => 'Cinema e streaming',
            'demo-bicicletta-citta.svg' => 'Mobilità urbana',
        ];

        $colors = [
            '#fbbf24',
            '#38bdf8',
            '#34d399',
            '#fb7185',
            '#a78bfa',
            '#2dd4bf',
        ];

        $disk = Storage::disk('public');
        $created = 0;
        $index = 0;

        foreach ($covers as $filename => $label) {
            $path = 'covers/' . $filename;
            $color = $colors[$index % count($colors)];
            $index++;

            // Conserva le copertine eventualmente già esistenti.
            if ($disk->exists($path)) {
                continue;
            }

            $safeLabel = htmlspecialchars(
                $label,
                ENT_QUOTES | ENT_XML1,
                'UTF-8'
            );

            $svg = <<<SVG
            <svg xmlns="http://www.w3.org/2000/svg"
                 width="1200" height="675" viewBox="0 0 1200 675">
                <title>{$safeLabel}</title>
                <rect width="1200" height="675" fill="#111827"/>
                <circle cx="1030" cy="120" r="240"
                        fill="{$color}" opacity="0.18"/>
                <circle cx="160" cy="610" r="260"
                        fill="{$color}" opacity="0.10"/>
                <rect x="90" y="170" width="12" height="270"
                      rx="6" fill="{$color}"/>
                <text x="140" y="235" fill="{$color}"
                      font-family="Arial, sans-serif"
                      font-size="24" letter-spacing="4">
                    THE AULAB POST
                </text>
                <text x="140" y="340" fill="#ffffff"
                      font-family="Arial, sans-serif"
                      font-size="48" font-weight="700">
                    {$safeLabel}
                </text>
                <text x="140" y="410" fill="#cbd5e1"
                      font-family="Arial, sans-serif" font-size="24">
                    Storie e idee dalla community
                </text>
                <path d="M850 470 L930 390 L1010 470"
                      fill="none" stroke="{$color}"
                      stroke-width="12" stroke-linecap="round"/>
            </svg>
            SVG;

            if (! $disk->put($path, $svg)) {
                throw new RuntimeException(
                    "Impossibile creare la copertina: {$path}"
                );
            }

            $created++;
        }

        $this->command?->info(
            "Copertine dimostrative create: {$created}."
        );
    }
}
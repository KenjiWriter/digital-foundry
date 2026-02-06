<?php

namespace App\Console\Commands;

use App\Models\Sector;
use Illuminate\Console\Command;

class CreateSector extends Command
{
    /**
     * The signature: name_en, name_pl, icon
     */
    protected $signature = 'audit:sector {en} {pl} {icon}';

    protected $description = 'Create a new business sector for the Audit Engine';

    public function handle()
    {
        $en = $this->argument('en');
        $pl = $this->argument('pl');
        $icon = $this->argument('icon');

        $sector = Sector::create([
            'name' => ['en' => $en, 'pl' => $pl],
            'icon' => $icon,
            'is_active' => true,
        ]);

        $this->info("✅ Sector [{$en} / {$pl}] created successfully! ID: {$sector->id}");
    }
}
<?php

namespace App\Console\Commands;

use App\Models\AuditQuestion;
use App\Models\Sector;
use Illuminate\Console\Command;

class CreateAuditQuestion extends Command
{
    // Signature: SectorName | EN Text | PL Text | VarName | Cost | EN Sugg | PL Sugg
    protected $signature = 'audit:question 
                            {sector_name : The English name of the sector} 
                            {q_en : Question in English} 
                            {q_pl : Question in Polish} 
                            {var : Internal variable name} 
                            {cost : Cost per unit} 
                            {s_en : Suggestion in English} 
                            {s_pl : Suggestion in Polish}';

    protected $description = 'Add a specific pain-point question to a sector';

    public function handle()
    {
        // 1. Znajdź sektor (szukamy po angielskiej nazwie w JSON)
        $sectorName = $this->argument('sector_name');

        // Laravel 12 JSON query syntax
        $sector = Sector::where('name->en', $sectorName)->first();

        if (!$sector) {
            $this->error("❌ Sector '{$sectorName}' not found. Create it first using audit:sector.");
            return;
        }

        // 2. Utwórz pytanie
        AuditQuestion::create([
            'sector_id' => $sector->id,
            'question_text' => [
                'en' => $this->argument('q_en'),
                'pl' => $this->argument('q_pl')
            ],
            'variable_name' => $this->argument('var'),
            'cost_per_unit' => (float) $this->argument('cost'),
            'suggestion_text' => [
                'en' => $this->argument('s_en'),
                'pl' => $this->argument('s_pl')
            ],
        ]);

        $this->info("✅ Question added to [{$sectorName}]: " . $this->argument('q_en'));
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sector;
use App\Models\AuditQuestion;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Logistics
        $logistics = Sector::create([
            'name' => [
                'en' => 'Logistics',
                'pl' => 'Logistyka',
            ],
            'icon' => 'Truck', // Lucide icon name
            'is_active' => true,
        ]);

        AuditQuestion::create([
            'sector_id' => $logistics->id,
            'question_text' => [
                'en' => 'What is your monthly volume of manual waybills?',
                'pl' => 'Ile listów przewozowych wypisujesz ręcznie miesięcznie?',
            ],
            'variable_name' => 'manual_waybills',
            'cost_per_unit' => 5.00, // $5 per unit
            'suggestion_text' => [
                'en' => 'We can automate your dispatch process to save $5 per shipment.',
                'pl' => 'Możemy zautomatyzować proces wysyłki, oszczędzając 20 PLN na przesyłce.',
            ],
        ]);

        // 2. E-commerce
        $ecommerce = Sector::create([
            'name' => [
                'en' => 'E-commerce',
                'pl' => 'E-commerce',
            ],
            'icon' => 'ShoppingBag', // Lucide icon name
            'is_active' => true,
        ]);

        AuditQuestion::create([
            'sector_id' => $ecommerce->id,
            'question_text' => [
                'en' => 'How many returns do you process manually per month?',
                'pl' => 'Ile zwrotów obsługujesz ręcznie w miesiącu?',
            ],
            'variable_name' => 'returns_handling',
            'cost_per_unit' => 15.00, // $15 per unit
            'suggestion_text' => [
                'en' => 'Automating RMA can reduce processing costs by 70%.',
                'pl' => 'Automatyzacja zwrotów może obniżyć koszty obsługi o 70%.',
            ],
        ]);

        // 3. B2B Services
        $b2b = Sector::create([
            'name' => [
                'en' => 'B2B Services',
                'pl' => 'Usługi B2B',
            ],
            'icon' => 'Briefcase', // Lucide icon name
            'is_active' => true,
        ]);

        AuditQuestion::create([
            'sector_id' => $b2b->id,
            'question_text' => [
                'en' => 'Hours spent on client reporting monthly?',
                'pl' => 'Ile godzin miesięcznie poświęcasz na raportowanie dla klientów?',
            ],
            'variable_name' => 'client_reporting',
            'cost_per_unit' => 50.00, // $50 per hour
            'suggestion_text' => [
                'en' => 'Automated dashboards can save you 100% of this time.',
                'pl' => 'Automatyczne dashboardy mogą zaoszczędzić 100% tego czasu.',
            ],
        ]);
    }
}

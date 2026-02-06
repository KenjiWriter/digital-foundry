<?php

namespace Database\Seeders;

use App\Models\AuditQuestion;
use App\Models\Sector;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RichContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Wyczyść stare dane
        Schema::disableForeignKeyConstraints();
        AuditQuestion::truncate();
        Sector::truncate();
        Schema::enableForeignKeyConstraints();

        // 2. Definicja Sektorów i Pytań (Wersja Rozszerzona)
        $sectors = [
            // --- LOGISTICS ---
            [
                'name' => ['en' => 'Logistics & Supply Chain', 'pl' => 'Logistyka i Transport'],
                'icon' => 'Truck',
                'questions' => [
                    [
                        'question_text' => ['en' => 'Monthly manual waybills/invoices processed?', 'pl' => 'Miesięczna liczba ręcznie wprowadzanych listów przewozowych?'],
                        'variable_name' => 'manual_docs',
                        'cost_per_unit' => 8.00, // Czas + ryzyko błędu
                        'suggestion_text' => ['en' => 'Auto-generate labels via API integrations.', 'pl' => 'Automatyzacja etykiet poprzez integracje API z kurierami.'],
                    ],
                    [
                        'question_text' => ['en' => 'Delivery failures/returns per month?', 'pl' => 'Liczba nieudanych doręczeń/zwrotów miesięcznie?'],
                        'variable_name' => 'returns_handling',
                        'cost_per_unit' => 25.00, // Obsługa magazynowa + ponowna wysyłka
                        'suggestion_text' => ['en' => 'Implement self-service returns portal.', 'pl' => 'Wdrożenie portalu zwrotów (RMA) dla klientów.'],
                    ],
                    [
                        'question_text' => ['en' => 'Empty/Dead miles driven per month (km)?', 'pl' => 'Liczba "pustych przebiegów" miesięcznie (km)?'],
                        'variable_name' => 'dead_mileage',
                        'cost_per_unit' => 1.50, // Paliwo + amortyzacja
                        'suggestion_text' => ['en' => 'AI Route Optimization & Load Balancing.', 'pl' => 'Optymalizacja tras i łączenie ładunków z użyciem AI.'],
                    ],
                ]
            ],
            // --- CONSTRUCTION ---
            [
                'name' => ['en' => 'Construction & Real Estate', 'pl' => 'Budownictwo i Deweloperka'],
                'icon' => 'HardHat',
                'questions' => [
                    [
                        'question_text' => ['en' => 'Field reports submitted on paper/week?', 'pl' => 'Tygodniowa liczba papierowych raportów z budowy?'],
                        'variable_name' => 'paper_reports',
                        'cost_per_unit' => 45.00, // Opóźnienie danych
                        'suggestion_text' => ['en' => 'Mobile app for on-site digital reporting.', 'pl' => 'Mobilna aplikacja do raportowania z terenu (Offline-first).'],
                    ],
                    [
                        'question_text' => ['en' => 'Lost/Misplaced tools or equipment per year?', 'pl' => 'Roczna liczba zgubionych narzędzi/sprzętu?'],
                        'variable_name' => 'lost_equipment',
                        'cost_per_unit' => 300.00, // Koszt odtworzenia
                        'suggestion_text' => ['en' => 'QR Code Asset Tracking System.', 'pl' => 'System śledzenia majątku QR/RFID.'],
                    ],
                ]
            ],
            // --- HR ---
            [
                'name' => ['en' => 'HR & Recruitment', 'pl' => 'HR i Agencje Pracy'],
                'icon' => 'Users',
                'questions' => [
                    [
                        'question_text' => ['en' => 'CVs processed manually per month?', 'pl' => 'Liczba CV analizowanych ręcznie w miesiącu?'],
                        'variable_name' => 'manual_cvs',
                        'cost_per_unit' => 15.00, // Czas rekrutera
                        'suggestion_text' => ['en' => 'Automated parsing and candidate scoring.', 'pl' => 'Automatyczny parsing CV i scoring kandydatów.'],
                    ],
                    [
                        'question_text' => ['en' => 'Hours spent on employee onboarding (admin)?', 'pl' => 'Godziny administracyjne na onboarding pracownika?'],
                        'variable_name' => 'onboarding_hours',
                        'cost_per_unit' => 40.00, // Czas HR + Managera
                        'suggestion_text' => ['en' => 'Self-service Digital Onboarding Portal.', 'pl' => 'Portal samoobsługowy dla nowych pracowników.'],
                    ],
                ]
            ],
            // --- E-COMMERCE ---
            [
                'name' => ['en' => 'E-commerce & Retail', 'pl' => 'E-commerce i Retail'],
                'icon' => 'ShoppingBag',
                'questions' => [
                    [
                        'question_text' => ['en' => 'Customer support tickets per month?', 'pl' => 'Miesięczna liczba zgłoszeń supportowych?'],
                        'variable_name' => 'support_tickets',
                        'cost_per_unit' => 12.00,
                        'suggestion_text' => ['en' => 'AI Chatbot & Order Status Dashboard.', 'pl' => 'AI Chatbot i Dashboard statusu zamówień.'],
                    ],
                    [
                        'question_text' => ['en' => 'Stockouts (Out of stock events) per month?', 'pl' => 'Liczba sytuacji "Brak towaru" (Overselling) miesięcznie?'],
                        'variable_name' => 'stockouts',
                        'cost_per_unit' => 50.00, // Utracona marża + wizerunek
                        'suggestion_text' => ['en' => 'Real-time Multi-channel Inventory Sync.', 'pl' => 'Synchronizacja stanów magazynowych w czasie rzeczywistym.'],
                    ],
                ]
            ],
            // --- LEGAL / SERVICES ---
            [
                'name' => ['en' => 'Professional Services', 'pl' => 'Usługi Profesjonalne (Prawnicy/B2B)'],
                'icon' => 'Scale',
                'questions' => [
                    [
                        'question_text' => ['en' => 'Unbilled billable hours missed per month?', 'pl' => 'Liczba niefakturowanych godzin w miesiącu?'],
                        'variable_name' => 'leakage_hours',
                        'cost_per_unit' => 150.00, // Utracony przychód
                        'suggestion_text' => ['en' => 'Real-time time tracking & auto-invoicing.', 'pl' => 'Śledzenie czasu pracy i automatyczne fakturowanie.'],
                    ],
                    [
                        'question_text' => ['en' => 'Minutes spent searching for files per case?', 'pl' => 'Minuty tracone na szukanie plików (per sprawa)?'],
                        'variable_name' => 'doc_search',
                        'cost_per_unit' => 25.00, // Czas eksperta
                        'suggestion_text' => ['en' => 'Centralized Document Management System (DMS).', 'pl' => 'Centralny system obiegu dokumentów (DMS) z OCR.'],
                    ],
                ]
            ],
            // --- MANUFACTURING ---
            [
                'name' => ['en' => 'Manufacturing', 'pl' => 'Produkcja'],
                'icon' => 'Factory',
                'questions' => [
                    [
                        'question_text' => ['en' => 'Paper job sheets processed per week?', 'pl' => 'Tygodniowa liczba papierowych kart pracy?'],
                        'variable_name' => 'paper_job_sheets',
                        'cost_per_unit' => 10.00,
                        'suggestion_text' => ['en' => 'Digital Kiosks for production floor tracking.', 'pl' => 'Cyfrowe kioski produkcyjne (MES).'],
                    ],
                ]
            ],
            // --- NEW: HEALTHCARE ---
            [
                'name' => ['en' => 'Healthcare & Clinics', 'pl' => 'Medycyna i Kliniki'],
                'icon' => 'Activity', // Upewnij się, że masz taką ikonę (lub 'Heart')
                'questions' => [
                    [
                        'question_text' => ['en' => 'Missed appointments (No-shows) per month?', 'pl' => 'Liczba nieodwołanych wizyt (No-shows) miesięcznie?'],
                        'variable_name' => 'no_shows',
                        'cost_per_unit' => 120.00, // Pusty gabinet
                        'suggestion_text' => ['en' => 'Automated SMS Reminders & Booking System.', 'pl' => 'Automatyczne przypomnienia SMS i system rezerwacji.'],
                    ],
                    [
                        'question_text' => ['en' => 'Hours spent on patient registration paperwork?', 'pl' => 'Godziny spędzone na papierologii rejestracyjnej (tyg)?'],
                        'variable_name' => 'registration_admin',
                        'cost_per_unit' => 35.00,
                        'suggestion_text' => ['en' => 'Digital Patient Portal & E-Forms.', 'pl' => 'Portal Pacjenta i elektroniczne ankiety przed wizytą.'],
                    ],
                ]
            ],
            // --- NEW: PROPERTY MANAGEMENT ---
            [
                'name' => ['en' => 'Property Management', 'pl' => 'Zarządzanie Nieruchomościami'],
                'icon' => 'Building',
                'questions' => [
                    [
                        'question_text' => ['en' => 'Maintenance requests handled via phone/text?', 'pl' => 'Zgłoszenia usterek obsługiwane przez telefon/SMS (mies)?'],
                        'variable_name' => 'maintenance_calls',
                        'cost_per_unit' => 20.00, // Czas zarządcy + chaos
                        'suggestion_text' => ['en' => 'Tenant Mobile App for Ticket Tracking.', 'pl' => 'Aplikacja dla najemców do zgłaszania usterek.'],
                    ],
                ]
            ],
        ];

        // 3. Pętla zapisująca do bazy
        foreach ($sectors as $sectorData) {
            $questions = $sectorData['questions'];
            unset($sectorData['questions']);

            $sectorData['is_active'] = true;

            // Utwórz sektor
            $sector = Sector::create($sectorData);

            // Dodaj pytania
            foreach ($questions as $questionData) {
                $sector->questions()->create($questionData);
            }
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectorNames = $this->getSectorNames();

        foreach ($sectorNames as $sectorName) {
            Sector::create(['name' => $sectorName]);
        }
    }

    private function getSectorNames(): array
    {
        return [
            'Agriculture', 'Automotive', 'Construction', 'Education',
            'Energy', 'Finance', 'Healthcare', 'Hospitality',
            'Information Technology', 'Manufacturing', 'Media', 'Pharmaceuticals',
            'Real Estate', 'Retail', 'Telecommunications', 'Transportation',
            'Utilities', 'Aerospace', 'Insurance', 'Marketing', 'Non-Profit',
            'Professional Services', 'Sports', 'Travel', 'E-commerce',
        ];
    }
}

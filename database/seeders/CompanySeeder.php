<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Sector;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::all()->pluck('id')->toArray();
        $sectorIds = Sector::all()->pluck('id')->toArray();

        if (!count($userIds) || !count($sectorIds)) {
            throw new \Exception('There must be at least one user and one section in the db before you call CompanySeeder');
        }

        $companiesPerUser = 15;
        $employeeRanges = ['1-10', '11-50', '51-250', '251-1000', '1000+'];

        foreach ($userIds as $userId) {
            for ($i = 0; $i < $companiesPerUser; $i++) {
                $companyName = fake()->unique()->company;
                $employeeRange = $employeeRanges[array_rand($employeeRanges)];
                Company::create([
                    'name' => $companyName,
                    'address' => fake()->address,
                    'website' => $this->generateWebsite($companyName),
                    'email' => $this->generateEmail($companyName),
                    'number_of_employees' => $this->generateNumberOfEmployees($employeeRange),
                    'user_id' => $userId,
                    'sector_id' => $sectorIds[array_rand($sectorIds)]
                ]);
            }
        }
    }

    private function generateWebsite(string $companyName): string
    {
        $companyName = str_replace(' ', '', $companyName);
        $companyName = str_replace(',', '-', $companyName);
        return strtolower($companyName) . '.com';
    }

    private function generateEmail(string $companyName): string
    {
        $companyName = str_replace(' ', '', $companyName);
        $companyName = str_replace(',', '-', $companyName);
        return strtolower($companyName) . '@example.com';
    }

    private function generateNumberOfEmployees(string $range): int
    {
        return match ($range) {
            '1-10' => rand(1, 10),
            '11-50' => rand(11, 50),
            '51-250' => rand(51, 250),
            '251-1000' => rand(251, 1000),
            '1000+' => rand(1001, 50000),
            default => rand(1, 50000)
        };
    }
}

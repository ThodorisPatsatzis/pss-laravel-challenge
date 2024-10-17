<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Sector;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        if(!count($userIds)) {

        }
        if(!count($sectorIds)) {

        }

        $companyNames = $this->getCompanyNames();
        $companiesPerUser = count($companyNames)/count($userIds);
        $employeeRanges = ['1-10', '11-50', '51-250', '251-1000', '1000+'];

        foreach($userIds as $userId) {
            for($i=0; $i<$companiesPerUser; $i++) {
                $companyName = $companyNames[array_rand($companyNames)];
                $employeeRange = $employeeRanges[array_rand($employeeRanges)];
                Company::create([
                   'name' =>  $companyName,
                    'address' => $this->generateAddress(),
                    'website' => $this->generateWebsite($companyName),
                    'email' => $this->generateEmail($companyName),
                    'number_of_employees' => $this->generateNumberOfEmployees($employeeRange),
                    'user_id' => $userId,
                    'sector_id' => $sectorIds[array_rand($sectorIds)]
                ]);
            }
        }
    }

    private function getCompanyNames(): array
    {
        return [
            'Tech Solutions', 'Health Corp', 'Green Energy', 'Finance Group',
            'Retail World', 'Automobile Hub', 'Foodies Delight', 'Construction Pros',
            'Digital Media', 'Education Services', 'Real Estate Experts',
            'Travel Agency', 'Consulting Inc', 'Telecom Solutions', 'Security Systems',
            'E-commerce Ventures', 'Pharmaceuticals Co', 'Fashion Outlet', 'Logistics LLC',
            'Marketing Gurus', 'Gaming Studios', 'Event Management', 'Artisan Crafts',
            'Software Innovations', 'Hardware Manufacturing', 'Cleaning Services'
        ];
    }

    private function generateAddress(): string
    {
        $addresses = [
            '123 Main St, Springfield, USA',
            '456 Elm St, Metropolis, USA',
            '789 Oak St, Gotham, USA',
            '321 Maple Ave, Smallville, USA',
            '654 Pine St, Star City, USA',
            '987 Birch St, Central City, USA',
            '135 Cedar St, Coast City, USA',
            '246 Willow St, National City, USA',
            '357 Walnut St, Blue Valley, USA',
            '864 Cherry St, Keystone City, USA',
        ];

        return $addresses[array_rand($addresses)];
    }

    private function generateWebsite(string $companyName): string
    {
        return strtolower(str_replace(' ', '', $companyName)) . '.com';
    }

    private function generateEmail(string $companyName): string
    {
        return strtolower(str_replace(' ', '', $companyName)) . '@example.com';
    }

    private function generateNumberOfEmployees(string $range): int
    {
        return match($range) {
            '1-10' => rand(1, 10),
            '11-50' => rand(11, 50),
            '51-250' => rand(51, 250),
            '251-1000' => rand(251, 1000),
            '1000+' => rand(1001, 50000),
            default => rand(1, 50000)
        };
    }
}

<?php

use App\Models\Company;
use App\Models\Sector;
use App\Models\User;
use App\Services\CompanyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $companyService;

    public function test_a_user_can_view_only_owned_companies_on_companies_list()
    {
        $this->companyService = new CompanyService();

        $user = User::factory()->create();

        $sector = Sector::factory()->create();

        Company::factory()->count(2)->create([
            'user_id' => $user->id,
            'sector_id' => $sector->id,
        ]);

        $this->actingAs($user);

        $retrievedCompanies = $this->companyService->getCompanies();

        $this->assertCount(2, $retrievedCompanies);
        foreach($retrievedCompanies as $company) {
            $this->assertEquals($company->user_id, $user->id);
        }
    }
}

<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Sector;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_view_edit_page_of_owned_companies_only()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();

        $sector = Sector::factory()->create();

        $userCompanies = Company::factory()->count(2)->create([
            'user_id' => $user->id,
            'sector_id' => $sector->id,
        ]);

        $anotherUserCompanies = Company::factory()->count(2)->create([
            'user_id' => $anotherUser->id,
            'sector_id' => $sector->id,
        ]);

        $this->actingAs($user);

        $ownedCompany = $userCompanies->first();

        $response = $this->get(route('company.edit', ['company' => $ownedCompany]));
        $response->assertStatus(200);

        $notOwnedCompany = $anotherUserCompanies->first();

        $response = $this->get(route('company.edit', ['company' => $notOwnedCompany]));
        $response->assertStatus(403);
    }
}

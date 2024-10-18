<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Sector;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCompanyRelationshipTest extends TestCase
{
    use RefreshDatabase;

    // Ensure that the relationship is working as expected
    public function test_a_user_can_have_many_companies(): void
    {
        $user = User::factory()->create();
        $sector = Sector::factory()->create();

        Company::factory()->count(2)->create([
            'user_id' => $user->id,
            'sector_id' => $sector->id
        ]);

        $this->assertCount(2, $user->companies);
        $this->assertTrue($user->companies->first()->user_id === $user->id);
    }

    // Ensure that the user's companies are being deleted if the user is being deleted
    public function test_companies_cascade_on_user_delete(): void
    {
        $user = User::factory()->create();
        $sector = Sector::factory()->create();

        Company::factory()->count(2)->create([
            'user_id' => $user->id,
            'sector_id' => $sector->id
        ]);

        $this->assertCount(2, $user->companies);

        $userId = $user->id;
        $user->delete();

        $this->assertCount(0, Company::where('user_id', $userId)->get());
    }
}

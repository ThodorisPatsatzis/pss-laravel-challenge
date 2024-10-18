<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_view_companies_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // ensure that user can view the page
        $response = $this->get('/companies');
        $response->assertStatus(200);
    }
}

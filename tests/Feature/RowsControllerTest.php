<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Row;
use Tests\TestCase;

class RowsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testRowsGroupedByDate(): void
    {
        Row::factory()->count(3)->create();

        $response = $this
            ->actingAs($this->user)
            ->getJson(route('rows.index'));

        $response->assertStatus(200);
    }
}


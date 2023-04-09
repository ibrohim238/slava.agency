<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImportRowControllerTest extends TestCase
{
    use RefreshDatabase;

    private readonly User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_import()
    {
        $testFile = new UploadedFile(base_path('./public/test.xlsx'), 'test.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', null, true);

        $response = $this
            ->actingAs($this->user)
            ->postJson(route('import'), [
                'excel' => $testFile,
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'importId'
        ]);
    }

    public function test_progress()
    {
        $testFile = new UploadedFile(base_path('./public/test.xlsx'), 'test.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', null, true);

        $response = $this
            ->actingAs($this->user)
            ->postJson(route('import'), [
                'excel' => $testFile,
            ]);

        $importId = $response->json('importId');

        $response = $this->getJson(route('import.progress', $importId));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'importId',
            'progress'
        ]);
    }

    public function test_import_validation()
    {
        $response = $this
            ->actingAs($this->user)
            ->postJson(route('import'), [
            'excel' => 'not-a-file',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('excel');
    }
}

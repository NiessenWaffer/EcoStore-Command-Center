<?php

namespace Tests\Feature;

use App\Models\ProductPassport;
use App\Models\User;
use App\Services\PassportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class PassportVerificationApiTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $passportService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->passportService = new PassportService();
    }

    public function test_guest_can_verify_passport_integrity()
    {
        $passport = ProductPassport::factory()->create();
        $this->passportService->recordEvent($passport, 'Sourcing', ['origin' => 'USA']);

        $response = $this->getJson(route('passports.verify', $passport->id));

        $response->assertStatus(200)
            ->assertJson([
                'is_verified' => true,
                'passport_id' => $passport->id
            ]);
    }

    public function test_admin_can_record_verified_event()
    {
        $admin = User::factory()->create();
        $passport = ProductPassport::factory()->create();

        $response = $this->actingAs($admin)
            ->postJson(route('admin.passports.events', $passport->id), [
                'event_type' => 'QualityCheck',
                'event_data' => ['result' => 'passed']
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('message', 'Event recorded successfully');

        $this->assertDatabaseHas('passport_audit_logs', [
            'passport_id' => $passport->id,
            'event_type' => 'QualityCheck',
            'performed_by' => $admin->id
        ]);
    }

    public function test_api_detects_tampering()
    {
        $passport = ProductPassport::factory()->create();
        $this->passportService->recordEvent($passport, 'Event1', ['d' => 'v1']);

        // Tamper
        $log = $passport->auditLogs()->first();
        \DB::table('passport_audit_logs')->where('id', $log->id)->update(['event_data' => '{"tampered":true}']);

        $response = $this->getJson(route('passports.verify', $passport->id));

        $response->assertStatus(200)
            ->assertJson(['is_verified' => false]);
    }
}

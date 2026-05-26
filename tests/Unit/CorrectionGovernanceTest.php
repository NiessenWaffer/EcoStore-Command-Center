<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\ProductPassport;
use App\Models\GovernanceProposal;
use App\Services\PassportService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CorrectionGovernanceTest extends TestCase
{
    use RefreshDatabase;

    protected $passportService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->passportService = app(PassportService::class);
    }

    /** @test */
    public function test_it_can_propose_a_correction()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $passport = \Database\Factories\ProductPassportFactory::new()->create();
        $log = $this->passportService->recordEvent($passport, 'Test', ['data' => 'old']);

        $proposal = $this->passportService->proposeCorrection($admin, $log->id, ['data' => 'new'], 'Typo');

        $this->assertDatabaseHas('governance_proposals', [
            'type' => 'Correction',
            'status' => 'Active',
        ]);
        $this->assertEquals($log->id, $proposal->options['log_id']);
    }

    /** @test */
    public function test_it_can_finalize_a_correction_after_approval()
    {
        $admin1 = User::factory()->create(['is_admin' => true]);
        $admin2 = User::factory()->create(['is_admin' => true]);
        $passport = \Database\Factories\ProductPassportFactory::new()->create();
        $log = $this->passportService->recordEvent($passport, 'Test', ['data' => 'old']);

        $proposal = $this->passportService->proposeCorrection($admin1, $log->id, ['data' => 'new'], 'Typo');
        
        $correctionLog = $this->passportService->finalizeCorrection($proposal, $admin2);

        $this->assertEquals('Correction', $correctionLog->event_type);
        $this->assertEquals($log->id, $correctionLog->event_data['original_log_id']);
        $this->assertDatabaseHas('governance_proposals', [
            'id' => $proposal->id,
            'status' => 'Executed',
        ]);
    }
}

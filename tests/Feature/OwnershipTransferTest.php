<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ProductPassport;
use App\Models\PassportTransfer;
use App\Services\PassportService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OwnershipTransferTest extends TestCase
{
    use RefreshDatabase;

    protected $passportService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->passportService = app(PassportService::class);
    }

    /** @test */
    public function test_it_can_initiate_an_ownership_transfer()
    {
        $sender = User::factory()->create();
        $passport = \Database\Factories\ProductPassportFactory::new()->create(['user_id' => $sender->id]);

        $transfer = $this->passportService->initiateTransfer($sender, $passport);

        $this->assertDatabaseHas('passport_transfers', [
            'passport_id' => $passport->id,
            'sender_id' => $sender->id,
            'status' => 'Pending',
        ]);
        $this->assertNotNull($transfer->token);
    }

    /** @test */
    public function test_it_cannot_initiate_transfer_if_one_is_already_pending()
    {
        $sender = User::factory()->create();
        $passport = \Database\Factories\ProductPassportFactory::new()->create(['user_id' => $sender->id]);

        $this->passportService->initiateTransfer($sender, $passport);

        $this->expectException(\Exception::class);
        $this->passportService->initiateTransfer($sender, $passport);
    }

    /** @test */
    public function test_it_can_complete_an_ownership_transfer()
    {
        $sender = User::factory()->create();
        $recipient = User::factory()->create();
        $passport = \Database\Factories\ProductPassportFactory::new()->create(['user_id' => $sender->id]);

        $transfer = $this->passportService->initiateTransfer($sender, $passport);
        
        $updatedPassport = $this->passportService->completeTransfer($recipient, $transfer->token);

        $this->assertEquals($recipient->id, $updatedPassport->user_id);
        $this->assertDatabaseHas('passport_transfers', [
            'id' => $transfer->id,
            'status' => 'Completed',
            'recipient_id' => $recipient->id,
        ]);
        
        $this->assertDatabaseHas('passport_audit_logs', [
            'passport_id' => $passport->id,
            'event_type' => 'OwnershipTransfer',
        ]);
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ProductPassport;
use App\Models\PassportAuditLog;
use App\Models\Product;
use App\Models\Factory;
use App\Services\PassportService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HashChainTest extends TestCase
{
    use RefreshDatabase;

    protected $passportService;
    protected $product;
    protected $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->passportService = new PassportService();
        $this->product = Product::factory()->create();
        $this->factory = Factory::factory()->create();
    }

    public function test_new_event_generates_correct_hash_chain()
    {
        \Carbon\Carbon::setTestNow(now()->subHours(1));
        $passport = ProductPassport::create([
            'product_id' => $this->product->id,
            'batch_number' => 'B1',
            'factory_id' => $this->factory->id,
            'manufacturing_date' => now(),
            'qr_token' => 't1'
        ]);

        $event1 = $this->passportService->recordEvent($passport, 'Sourcing', ['m' => 'Cotton']);
        $this->assertEquals('genesis', $event1->previous_hash);
        $this->assertEquals($passport->last_audit_hash, $event1->current_hash);

        \Carbon\Carbon::setTestNow(now()->addMinute());
        $event2 = $this->passportService->recordEvent($passport, 'Manufacturing', ['f' => 'Factory1']);
        $this->assertEquals($event1->current_hash, $event2->previous_hash);
        $this->assertEquals($passport->last_audit_hash, $event2->current_hash);
        \Carbon\Carbon::setTestNow();
    }

    public function test_verify_integrity_detects_tampering()
    {
        \Carbon\Carbon::setTestNow(now()->subHours(1));
        $passport = ProductPassport::create([
            'product_id' => $this->product->id,
            'batch_number' => 'B1',
            'factory_id' => $this->factory->id,
            'manufacturing_date' => now(),
            'qr_token' => 't2'
        ]);

        $this->passportService->recordEvent($passport, 'Event1', ['d' => '1']);
        \Carbon\Carbon::setTestNow(now()->addMinute());
        $this->passportService->recordEvent($passport, 'Event2', ['d' => '2']);

        $this->assertTrue($this->passportService->verifyIntegrity($passport));

        // Tamper with a record manually in DB
        $log = $passport->auditLogs()->first();
        \DB::table('passport_audit_logs')
            ->where('id', $log->id)
            ->update(['event_data' => json_encode(['d' => 'tampered'])]);

        $this->assertFalse($this->passportService->verifyIntegrity($passport));
        \Carbon\Carbon::setTestNow();
    }

    public function test_correction_event_maintains_valid_chain()
    {
        \Carbon\Carbon::setTestNow(now()->subMinutes(10));
        $passport = ProductPassport::create([
            'product_id' => $this->product->id,
            'batch_number' => 'B1',
            'factory_id' => $this->factory->id,
            'manufacturing_date' => now(),
            'qr_token' => 't3'
        ]);

        $log1 = $this->passportService->recordEvent($passport, 'Event1', ['d' => 'wrong']);
        
        \Carbon\Carbon::setTestNow(now()->addMinutes(1));
        // Add correction
        $log2 = $this->passportService->recordEvent($passport, 'Correction', [
            'original_log_id' => $log1->id,
            'd' => 'corrected'
        ]);

        $this->assertTrue($this->passportService->verifyIntegrity($passport));
        $this->assertEquals($log1->current_hash, $log2->previous_hash);
        \Carbon\Carbon::setTestNow();
    }
}

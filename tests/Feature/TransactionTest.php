<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Model\Transaction;

class TransactionTest extends TestCase
{
    /** @test */
    public function a_transaction_can_be_made(){
        $this->post('/api/transactions');  
        
        $this->assertCount(1, Transaction::all());
    }
}

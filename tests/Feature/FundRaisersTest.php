<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FundRaisersTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetFundRaisers()
    {
        $response = $this->get('/fundraisers');

        $response->assertStatus(200);
    }
}

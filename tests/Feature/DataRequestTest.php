<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataRequestTest extends TestCase
{
    /**
     * Description - We test our basic http request without any parameters to get data
     *
     * @return void
     */
    public function testBasicHttpRequest()
    {
        /* -----------------------------------------------------------------------------------
        *   we send the authorization header here in the request to check our request's status
        * ------------------------------------------------------------------------------------*/
        $response = $this->withHeaders([
            'Authorization' => 'Basic dGVzdFVzZXI6dGVzdFBhc3N3b3Jk',
        ])->json('GET', '/api/data');
        
        /* -----------------------------------------------------------------------------------
        *   here if everything goes well , this returs 200. and our test case passes.
        * ------------------------------------------------------------------------------------*/
        $response->assertStatus(200);
    }


    
    /**
     * Description - We test our http request by passing column name and condition to get data
     *
     * @return void
     */
    public function testConditionalHttpRequest()
    {
        /* -----------------------------------------------------------------------------------
        *   we send the authorization header here in the request to check our request's status
        * ------------------------------------------------------------------------------------*/
        $response = $this->withHeaders([
            'Authorization' => 'Basic dGVzdFVzZXI6dGVzdFBhc3N3b3Jk',
        ])->json('GET', '/api/data/first_name/Amy');
        
        /* ------------------------------------------------------------------------------------------------
        *  Status should equal to 200. and message should equal to SUCCESS constant, config/constants.php
        * -------------------------------------------------------------------------------------------------*/
        $response->assertStatus(200)->assertJson(['message'=>SUCCESS]);
    }
}

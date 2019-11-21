<?php

namespace Tests\Unit;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Traits\CSVTrait;

class CSVTraitTest extends TestCase
{
    use CSVTrait;

    /**
     * Description - In this method we unit test the isColumnAvailable method that is inside of CSVTrait
     *
     * @return void
     */
    public function testIsColumnAvailable()
    {
        /* ----------------------------------------------------
        *   in below $csvData var we have faked the header data
        * -----------------------------------------------------*/
        $csvData = [['first_name','last_name','address']]; 
        
        $column = 'first_name';

        /*
        |--------------------------------------------------------------------------
        | Success Scenario
        |--------------------------------------------------------------------------
        |
        | Let's test the success scenario
        |
        */

        $resp = $this->isColumnAvailable($column, $csvData);

        /* ------------------------------------------------------------------------------
        *   we compare the response of isColumnAvailable in case when column is available
        * -------------------------------------------------------------------------------*/
        $this->assertEqualsCanonicalizing($resp,["key"=>0,"name"=>"first_name"]);
        

        /*
        |--------------------------------------------------------------------------
        | Failure Scenario
        |--------------------------------------------------------------------------
        |
        | Let's test the failure scenario
        |
        */

        $resp = $this->isColumnAvailable('unknown_column', $csvData);

        /* ----------------------------------------------------------------------------------
        *   we compare the response of isColumnAvailable method in case when column not found
        * -----------------------------------------------------------------------------------*/
        $this->assertFalse($resp);
        
    }





    /**
    * ---------------------------------------------------------------------------------------------------
    *  Description - In this method we unit test the checkAndReturnData method that is inside of CSVTrait
    * ---------------------------------------------------------------------------------------------------
    * 
    * @method testCheckAndReturnData
    * @return void
    */
    public function testCheckAndReturnData()
    {
        /* -----------------------------------------------------------------------------
        *   in below $csvData var we have faked the data that we get pass to this method
        * ------------------------------------------------------------------------------*/
        $csvData = [[['first_name','last_name','address'],['usman','liaqat','lahore']]]; 
        
        $column = 'last_name';

        /*
        |--------------------------------------------------------------------------
        | NO Data Scenario
        |--------------------------------------------------------------------------
        |
        | Let's test the no data scenario
        |
        */

        $resp = $this->checkAndReturnData($column, []);

        /* ------------------------------------------------------------------------------------
        *   we compare the response of checkAndReturnData in case when any of data is available
        * -------------------------------------------------------------------------------------*/
        $this->assertEquals($resp,response()->json(["message"=>"No data found","data"=>$this->responseFormat],200));
        

        /*
        |--------------------------------------------------------------------------
        | NULL Column Scenario
        |--------------------------------------------------------------------------
        |
        | Let's test the NULL column scenario, If it gets true then it returs all the data
        |
        */

        $resp = $this->checkAndReturnData(null, $csvData);

        /* ----------------------------------------------------------------------------------------
        *   we compare the response of checkAndReturnData method in case when column passed is null
        * -----------------------------------------------------------------------------------------*/
        $this->assertEquals($resp,response()->json(['message'=>"Success","data"=>$csvData[0]],200));


        /*
        |--------------------------------------------------------------------------
        | Both Data And Column Available Scenario
        |--------------------------------------------------------------------------
        |
        | Let's test this scenario, it returns true when column is not null and data is available
        |
        */

        $resp = $this->checkAndReturnData($column, $csvData);

        /* -----------------------------------------------------------------------------------
        *   we compare the response of checkAndReturnData method in case when it returns false
        * ------------------------------------------------------------------------------------*/
        $this->assertFalse($resp);
        
    }
}

<?php

namespace App\Traits;

trait CSVTrait
{
    /*
    |--------------------------------------------------------------------------
    | Description
    |--------------------------------------------------------------------------
    | We are using this trait as a helper
    |
    */


    
    /**
     * Description - response format always should be same to avoid errors on client side.
     * 
     * @var array $responseFormat
    */
    public $responseFormat = [];

    /**
     * Description - this method checks if there is column name available that was passed in the request
     * 
     * @method isColumnAvailable
     * @param  string|null $column
     * @param  array|null  $csvData
     * @return array|false
     */
    public function isColumnAvailable($column, $csvData){
        
        /* ------------------------------------------------------------------------
        *  value that is expected to be returned by this method if column not found
        * -------------------------------------------------------------------------*/
        $returnValue = false;
        /* ------------------------------------------------------------------------
        *  it checks that whether passed csvData contains header row or not
        * -------------------------------------------------------------------------*/
        if(is_array($csvData) && count($csvData)>0 && count($csvData[0])>0)
        {
            
            foreach($csvData[0] as $index=>$columnName){
                /* ------------------------------------------------------------------------
                *  here it return array if it finds the column name in our records
                * -------------------------------------------------------------------------*/
                if($columnName==$column)
                $returnValue = ["key"=>$index,"value"=>$columnName]; // store found column's index and name
            }
        }   

        return $returnValue;
    }

    /**
     * Description - this method checks availability of data
     * 
     * @method checkAndReturnData
     * @param  string|null $column
     * @param  array|null $data
     * @return string|false
     */
    public function checkAndReturnData($column,$data){
        
        /* ------------------------------------------------------------------------
        *  if data is not available in our data source then we return no data found
        * -------------------------------------------------------------------------*/
        if(!is_array($data) || sizeof($data)===0 )
        return response()->json(["message"=>"No data found","data"=>$this->responseFormat],200);
        /* -----------------------------------------------------------------------------
        *  if $column is not passed in the request then return all the data if available
        * ------------------------------------------------------------------------------*/
        else if($column===null )
        return response()->json(['message'=>"Success","data"=>$data[0]],200);
        /* --------------------------------------------------------------------------------------------
        *  return false means that we have data and we also have the column name passed so move forward
        * ---------------------------------------------------------------------------------------------*/
        else
        return false;
    }
}



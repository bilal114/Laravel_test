<?php

namespace App\Http\Controllers\CSVModule;

use Excel;
use App\Imports\CSVImport;
use App\Http\Controllers\Controller;
use App\Traits\CSVTrait;
use StdClass;
use App\Interfaces\CSVInterface;

/* ---------------------------------------------------------------------------
*   HERE WE ARE USING THE SINGLE ACTION CONTROLLER
* ----------------------------------------------------------------------------*/

class GetDataController extends Controller implements CSVInterface
{
    use CSVTrait;
   
    /**
     * [it find the column name and then find the data that passed by 2nd param, if not found return all ]
     * 
     * @param string|null $column - column name that user want to access
     * @param string|null $whereEqualTo - it will be used to match the passed column's data
     * 
     * @return Array|null
     */
    public function __invoke ($column = null, $whereEqualTo = null){

        $csvData = Excel::toArray(new StdClass,storage_path('csv/transactions.csv'));

        // it is checking availability of data 
        $dataAvailability = $this->checkAndReturnData($column,$csvData);
        /* ---------------------------------------------------------------------------
        *  checking if there is some response if yes then return, otherwise move forward
        * ----------------------------------------------------------------------------*/
        if($dataAvailability)
        return $dataAvailability;

        /* ---------------------------------------------------------------------------
        *  checks column availability and also returns key to get column specific data
        * ----------------------------------------------------------------------------*/
        if($key = $this->isColumnAvailable($column,$csvData[0]))
        {
            
            /* ----------------------------------------
            *  here we remove the first row mean header
            * -----------------------------------------*/
            $data = $csvData[0];
            array_shift($data);
            /* -------------------------------
            *  here we loop on each row/record
            * --------------------------------*/
            foreach($data as $value){
                /* -----------------------------------------------------------------------------------
                *  here we just check if record on which, currently we are matches or not and store it
                * ------------------------------------------------------------------------------------*/
                if($whereEqualTo!==null && $value[$key['key']]==$whereEqualTo)
                {
                    array_push($this->responseFormat,$value);
                }
                
            }
            /* ---------------------------------------------------
            *  SUCCESS constant is defined in config/constants.php
            * ----------------------------------------------------*/
            if(count($this->responseFormat)>0)
            return response()->json(["message"=>SUCCESS,"data"=>$this->responseFormat],200);

            /* ----------------------------------------------------------------------------------------
            *  we return the below response when column is available but matching data is not available 
            * -----------------------------------------------------------------------------------------*/
            return response()->json(["message"=>"No data found where '{$key['value']}' is equal to '{$whereEqualTo}'","data"=>$this->responseFormat],200);
        }
        else
        {
            /* ---------------------------------------------------------------------------
            *  we return this response in case passed column does not exist in our records
            * ----------------------------------------------------------------------------*/
            
            return response()->json(["message"=>"No such column found that matches with column '{$column}' you passed ","data"=>$this->responseFormat],200);
        }

    }
}

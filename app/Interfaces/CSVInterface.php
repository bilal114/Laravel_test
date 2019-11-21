<?php

namespace App\Interfaces;


interface CSVInterface
{

    public function checkAndReturnData($column,$data);

    public function isColumnAvailable($column,$csvData);
    
}



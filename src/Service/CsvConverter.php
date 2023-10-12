<?php

namespace App\Service;

use UnexpactedValueException;
class CsvConverter 
{
    public function csvToAssociativeArray($file, $delimiter = ',', $enclosure = '"') : ?array 
    {
        $fileMimes = array(
            'text/x-comma-separated-values',
            'text/comma-separated-values',
            'application/octet-stream',
            'application/vnd.ms-excel',
            'application/x-csv',
            'text/x-csv',
            'text/csv',
            'application/csv',
            'application/excel',
            'application/vnd.msexcel',
            'text/plain'
        );

        //validation 
        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes)){
        if (($handle = fopen($file, "r")) !== false) {
            $headers = fgetcsv($handle, 0, $delimiter, $enclosure);
            $lines = [];
            while (($data = fgetcsv($handle, 0, $delimiter, $enclosure)) !== false) {
                $current = [];
                $i = 0;
                foreach ($headers as $header) {
                    $current[$header] = $data[$i++];
                }
                $lines[] = $current;
            }
            fclose($handle);
            return $lines;
        } 
    } else {
        throw new UnexpactedValueException('Only csv files are allowed');
    }
}
}

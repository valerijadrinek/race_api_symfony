<?php

namespace App\Service;


class CsvConverter 
{
    public function csvToAssociativeArray($file, $delimiter = ',', $enclosure = '"') : ?array 
    {
        $validation = $this->validateCsvFile($file);
        //validation 
        if ($validation === true){
        //creating an associate array
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
    } 
}

    public function csvToDb($file)
    {
        $validation = $this->validateCsvFile($file);

        if($validation === true) {
        // Open uploaded CSV file with read-only mode
        $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

        // Skip the first line
        fgetcsv($csvFile);
        //return clean file to upload
        return $csvFile;
        }



    }

    private function validateCsvFile($file) : bool 
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
        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes))
        {
            return true;
        } else {
            return false;
        }

   }
}

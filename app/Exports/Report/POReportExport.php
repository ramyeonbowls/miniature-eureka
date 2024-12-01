<?php

namespace App\Exports\Report;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class POReportExport implements WithMultipleSheets
{
    private $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        return [
            new POHeaderExport($this->data),
            new PODetailExport($this->data),
        ];
    }
}

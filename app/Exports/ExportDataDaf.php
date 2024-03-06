<?php

namespace App\Exports;
use App\Models\Paiement;
use App\Models\TypeMedia;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class ExportDataDaf implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
     use Exportable;
     public $search;
     public $donner;
     public $head = [];
     public function __construct($query, $head)
     {
        $this->donner = $query;
        $this->head = $head;
     }

    public function headings(): array
    {
        return $this->head;
    }
    public function query()
    {
       return $this->donner;

    }


}

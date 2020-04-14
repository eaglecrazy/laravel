<?php

namespace App\Exports;

use App\News;
use Maatwebsite\Excel\Concerns\FromCollection;

class NewsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return News::all();
    }
}

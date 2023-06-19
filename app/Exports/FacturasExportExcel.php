<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FacturasExportExcel implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $facturas = [];

    public function __construct($facturas)
    {
        $this->facturas = $facturas;
    }

    public function view(): View
    {
        return view('excel.facturas', [
            'facturas' => $this->facturas
        ]);
    }
}

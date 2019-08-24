<?php

namespace App\Exports;

use App\Products;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProductsExport implements FromCollection, WithMapping, WithHeadings, /* WithDrawings, */ ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection() {
        return Products::all();
    }

    public function map($product): array {
        
        $item = [];
        $columns = Schema::getColumnListing('products');

        foreach ($columns as $column) {
            $item[$column] = $product->$column;
            if ($column == "category") $item[$column] = $product->categoryinfo->name;
            if ($column == "provider" && $product->provider != null) $item[$column] = $product->providerinfo->name;
            if ($column == "sell_type") $item[$column] = ($product->sell_type == 1) ? "Unidad" : (($product->sell_type == 2) ? "Peso" : "Metro");
            if ($column == "image") unset($item[$column]);
            if ($column == "created_at") $item[$column] = Date::dateTimeToExcel($product->created_at);      
            if ($column == "updated_at") $item[$column] = Date::dateTimeToExcel($product->updated_at);                          
        }

        return $item;
    }

    public function headings(): array
    {
        return ["Identificador", "Nombre", "Marca", "Categoría", "Precio al público", "Precio al por mayor", "Precio del proveedor", "Código", "Proveedor", "Tipo de venta", "Descripción", "Stock", "Peso", "Tamaño", "Fecha de registro", "Fecha de última modificación"];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $headersRange = 'A1:P1'; // All headers
                $allBodyRange = 'A2:P500'; // All body
                $allCellsRange = 'A1:P'.(Products::count()+1); // All cells

                $styleHeaderArray = [
                    'font' => [
                        'bold' => true,
                        'color' => [
                            'argb' => 'FFFFFF',
                        ],
                        "size" => 13
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => [
                            'argb' => '2C3E50',
                        ]
                    ],
                ];

                $styleAllCellsArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ]
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'wrap' => true,
                    ]
                ];

                $styleAllBodyArray = [
                    'font' => [
                        "size" => 10
                    ]
                ];

                $event->sheet->getStyle($headersRange)->applyFromArray($styleHeaderArray);
                $event->sheet->getStyle($allBodyRange)->applyFromArray($styleAllBodyArray);
                $event->sheet->getStyle($allCellsRange)->applyFromArray($styleAllCellsArray);
                $event->sheet->getDefaultRowDimension()->setRowHeight(25);
            },
        ];
    }

}

<?php

namespace App\Exports\Report;

use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromArray;

class POHeaderExport implements FromArray, WithHeadings, WithTitle, WithEvents, ShouldAutoSize
{
    private $data;

    public function __construct($data = [])
    {
        $this->data = $data;

        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });
    }

    public function array(): array
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Laporan Pembelian';
    }

    public function headings(): array
    {
        return [
            'Nama WL',
            'Provinsi',
            'Kab/Kota',
            'Nomor PO',
            'Jenis PO',
            'Tanggal',
            'Total'
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $event) {
                $event->writer->getProperties()->setTitle('Laporan Pembelian');
                $event->writer->getProperties()->setCreator(config('app.name'));
            },
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->styleCells('A1:G1', [
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['argb' => 'ffb4c6e7'],
                    ],
                ]);

                $event->sheet->styleCells('A1:G1', [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '808080'],
                        ],
                    ],
                ]);

                if (count($this->data) > 0) {
                    $event->sheet->styleCells('A2:G' . (count($this->data) + 1), [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '808080'],
                            ],
                        ],
                    ]);

					$event->sheet->styleCells('G2:G' . (count($this->data) + 1), [
						'numberFormat' => [
							'formatCode' => '#,##0.00',
						],
					]);
                }
            },
        ];
    }
}

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
use App\Services\Report\POReportService;

class PODetailExport implements FromArray, WithHeadings, WithTitle, WithEvents, ShouldAutoSize
{
    private $data;
    private $PO_service;

    public function __construct($data = [])
    {
        $this->PO_service = new POReportService();
        $this->data = $data;

        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });
    }

    public function array(): array
    {
        $details = [];
        foreach ($this->data as $val) {
            $filter['PO_NUMBER'] = $val['po_number'] ?? '';
            $filter['PO_DATE'] = $val['po_date'] ?? '';
            $filter['PO_TYPE'] = $val['po_type'] ?? '';
            $detailData = $this->PO_service->getDetail($filter);

            if (count($detailData) > 0) {
                $details[] = [
                    'Nomor PO',
                    'Tanggal PO',
                    'Judul Buku',
                    'Penulis',
                    'Penerbit',
                    'Qty',
                    'Harga Beli'
                ];

                foreach ($detailData as $det) {
                    $details[] = [
                        $det->po_number,
                        $det->po_date,
                        $det->title,
                        $det->writer,
                        $det->publisher,
                        $det->qty,
                        ($det->sellprice =='0') ? '0.00' : $det->sellprice
                    ];
                }
            }
        }
        return $details;
    }

    public function title(): string
    {
        return 'Detail Pembelian';
    }

    public function headings(): array
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $event) {
                $event->writer->getProperties()->setTitle('Detail Pembelian');
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
                        'color' => ['argb' => 'BFBFBF'],
                    ],
                ]);

                if (count($this->array()) > 0) {
                    $event->sheet->styleCells('A1:G' . (count($this->array())), [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '808080'],
                            ],
                        ],
                    ]);

					$event->sheet->styleCells('G2:G' . (count($this->array())), [
						'numberFormat' => [
							'formatCode' => '#,##0.00',
						],
					]);
                }
            },
        ];
    }
}

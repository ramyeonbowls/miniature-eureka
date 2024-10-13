<?php

namespace App\Exports\Report;

use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class BookReportExport implements WithCustomStartCell, WithHeadings, WithTitle, WithEvents, ShouldAutoSize
{
    private $data;

    public function __construct($data = [])
    {
        $this->data         = $data;

        Sheet::macro('setOrientation', function (Sheet $sheet, $orientation) {
            $sheet->getDelegate()->getPageSetup()->setOrientation($orientation);
        });

        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });
    }
    
    /**
     * @return string
     */
    public function startCell(): string
    {
        $starCell = 'A1';

        return $starCell;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Laporan Buku';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama WL',
            'Provinsi',
            'Kab/Kota',
            'Judul Buku',
            'Penerbit',
            'Penulis',
            'ISBN',
            'EISBN',
            'Copy'
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $event) {
                $event->writer->getProperties()->setTitle( 'Laporan Buku' );
                $event->writer->getProperties()->setCreator( config('app.name') );
            },
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

                $event->sheet
                    ->styleCells('A1:I1', [
                        'font' => [
                           'bold' => true
                        ],
                        'alignment' => [
                           'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                           'vertical'     => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                        ],
                        'fill' => [
                           'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                           'color' => ['argb' => 'ffb4c6e7']
                        ]
                    ]);

                $event->sheet
                    ->styleCells('A1:I1', [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '808080'],
                            ],
                        ],
                    ]
                );

                $row = 2;
                foreach ($this->data as $val) {
                    $event->sheet->setCellValue('A'.$row, $val['wl_name']);
                    $event->sheet->setCellValue('B'.$row, $val['provinsi_name']);
                    $event->sheet->setCellValue('C'.$row, $val['kabupaten_name']);
                    $event->sheet->setCellValue('D'.$row, $val['title']);
                    $event->sheet->setCellValue('E'.$row, $val['publisher']);
                    $event->sheet->setCellValue('F'.$row, $val['writer']);
                    $event->sheet->setCellValue('G'.$row, $val['isbn']);
                    $event->sheet->setCellValue('H'.$row, $val['eisbn']);
                    $event->sheet->setCellValue('I'.$row, $val['qty']);

                    $row++;
                }

                if(count($this->data) > 0){
                    $event->sheet
                        ->styleCells('A2:I'.($row-1), [
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    'color' => ['rgb' => '808080'],
                                ],
                            ],
                        ]
                    );
                }
            }
        ];
    }
}

<?php
//include the classes needed to create and write .xlsx file
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PHP Excel Class
 *
 * @author    Sandeep Kumar <ki.sandeep11@gmail.com>
 */
class Php_excel
{
    private $excel;

    public function __construct()
    {
    }

    public function load($file)
    {

        //$this->excel = new XLSXReader($file);
        // return $this->excel;
        $this->excel = IOFactory::load($file);
        return $this->excel;
    }

    public function getSheetName()
    {
        //return $this->excel->getSheetNames();
        return $this->excel->getSheetNames();
    }

    public function getSheetData($sheet_name)
    {
        // if (gettype($sheet_name) == 'string') {
        //     $sheet = $this->excel->getSheet($sheet_name);
        //     $data = $sheet->getData();
        //     return $data;
        // } else {
        //     foreach ($sheet_name as $sheet_name_single) {
        //         $sheet = $this->excel->getSheet($sheet_name_single);
        //         $data[] = $sheet->getData();
        //     }
        //     return $data;
        // }

        return $xls_data = $this->excel->getActiveSheet()->toArray(null, true, true, true);
    }

    public function createExcel($file_name = NULL, array $excel_header = NULL, array $array_data = NULL, $padding = NULL, $array_format = FALSE)
    {
        ob_clean();
        $filename = ($file_name) ? $file_name : 'Excel';

        //object of the Spreadsheet class to create the excel data
        $spreadsheet = new Spreadsheet();

        $col = 1;
        foreach ($excel_header as $field) {
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, 1,  ucwords(str_replace("_", " ", $field)));
            $col++;
        }

        // Fetching the table data
        $row = 2;
        foreach ($array_data as $data) {
            $col = 1;
            foreach ($excel_header as $field) {
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data[$field]);
                $col++;
            }

            $row++;
        }
        foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {

            $spreadsheet->setActiveSheetIndex($spreadsheet->getIndex($worksheet));

            $sheet = $spreadsheet->getActiveSheet();
            $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            /** @var PHPExcel_Cell $cell */
            foreach ($cellIterator as $cell) {
                $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
            }
        }
        //$spreadsheet->getActiveSheet()->setTitle('Simple'); //set a title for Worksheet

        $spreadsheet->setActiveSheetIndex(0);

        $objWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');

        // redirect output to client browser
        //header("Content-type: application/octet-stream");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');

        //make object of the Xlsx class to save the excel file
        //$writer = new Xlsx($spreadsheet);
        //$fxls ='excel-file_1.xlsx';
        //$writer->save($fxls);
    }
}

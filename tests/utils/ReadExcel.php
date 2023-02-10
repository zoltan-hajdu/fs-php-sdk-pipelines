<?php

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once __DIR__ . '/../../vendor/autoload.php';

class ReadExcel
{
    /**
     * @var Spreadsheet
     */
    protected $spreadSheet;

    /**
     * Reads data from an XLS file
     *
     * @param $excelFileName
     * @param $sheetName
     * @param $ScriptName
     * @return array|void
     */
    public function getTestData($excelFileName, $sheetName, $ScriptName)
    {
        try {
            $columnHeader = 3;
            $dataRow = -1;
            $inputFileType = IOFactory::identify($excelFileName);
            $reader = IOFactory::createReader($inputFileType);
            $reader->setReadDataOnly(true);
            $reader->setLoadSheetsOnly($sheetName);
            $this->spreadSheet = $reader->load($excelFileName);
            $highestRow = $this->spreadSheet->getActiveSheet()->getHighestRow();
            for ($index = $columnHeader + 1; $index <= $highestRow; $index++) {
                $columnValue = $this->spreadSheet->getActiveSheet()->getCellByColumnAndRow(2, $index)->getValue();
                if ($columnValue == $ScriptName) {
                    $dataRow = $index;
                    break;
                }
            }
            $highestColumn = $this->spreadSheet->getActiveSheet()->getHighestColumn();
            $highestColumn = Coordinate::columnIndexFromString($highestColumn);
            $testData = [];
            for ($columnIndex = 1; $columnIndex <= $highestColumn; $columnIndex++) {
                $columnName = $this->spreadSheet->getActiveSheet()->getCellByColumnAndRow($columnIndex, $columnHeader)->getValue();
                $columnValue = $this->spreadSheet->getActiveSheet()->getCellByColumnAndRow($columnIndex, $dataRow)->getValue();
                preg_match('/\=(.*)\!([A-Z]+\d+)/', $columnValue, $matches);
                if (isset($matches[1]) && isset($matches[2])) {
                    $columnValue = $this->getCommonData($excelFileName, $matches[1], $matches[2]);
                }
                $testData[$columnName] = $columnValue;
            }
            return $testData;
        } catch (Exception $exception) {
            print($exception);
        }
    }

    /**
     * Get linked data from Data sheet
     *
     * @param $excelFileName
     * @param $sheetName
     * @param $cell
     * @return mixed
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    private function getCommonData($excelFileName, $sheetName, $cell)
    {
        $inputFileType = IOFactory::identify($excelFileName);
        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $reader->setLoadSheetsOnly($sheetName);
        $dataSheet = $reader->load($excelFileName);
        return $dataSheet->getSheetByName($sheetName)->getCell($cell)->getValue();
    }
}


<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use SleekDB\Store;

class ReportHandler
{
    const TEST_STORE_CONFIGURATION = [
        "auto_cache" => true,
        "cache_lifetime" => null,
        "timeout" => false,
        "primary_key" => "_id",
        "search" => [
            "min_length" => 2,
            "mode" => "or",
            "score_key" => "scoreKey",
            "algorithm" => 1
        ]
    ];

    const REPORT_STORE_CONFIGURATION = [
        "auto_cache" => false,
        "cache_lifetime" => null,
        "timeout" => false,
        "primary_key" => "report_id",
        "search" => [
            "min_length" => 2,
            "mode" => "or",
            "score_key" => "scoreKey",
            "algorithm" => 1
        ]
    ];

    public function initTestStore(): Store
    {
        return new Store('testData', __DIR__ . "/../reports/reports", self::TEST_STORE_CONFIGURATION);
    }

    public function initReportStore(): Store
    {
        return new Store('records', __DIR__ . '/../reports/reports', self::REPORT_STORE_CONFIGURATION);;
    }

    public function getFileName($filePath): string
    {
        return basename($filePath, '.php');
    }

    public function getDateTime(): string
    {
        return date("h:i:s A");
    }

    public function getInfoData($stepName): array
    {
        return [
            "status" => 'info',
            "timestamp" => $this->getDateTime(),
            "step_name" => $stepName,
            "details" => $stepName
        ];
    }

    public function getRequestData($stepName, $details): array
    {
        return [
            "status" => 'info',
            "timestamp" => $this->getDateTime(),
            "step_name" => $stepName . ' Request',
            "details" => $details
        ];
    }

    public function getResponseData($stepName, $details): array
    {
        return [
            "status" => 'info',
            "timestamp" => $this->getDateTime(),
            "step_name" => $stepName . ' Response',
            "details" => $details
        ];
    }

    public function getTestValidationData($status, $stepName, $message): array
    {
        return [
            "status" => $status,
            "timestamp" => $this->getDateTime(),
            "step_name" => $stepName,
            "details" => $message
        ];
    }

    public function getErrorData($stepName, $message): array
    {
        return [
            "status" => 'error',
            "timestamp" => $this->getDateTime(),
            "step_name" => $stepName,
            "details" => $message
        ];
    }

    public function getTestRecord($startDate, $fileName, $stepData): array
    {

        $endDate = date_create();
        $endDateFormat = $endDate->format('Y-m-d h:i:s A');
        $interval = date_diff($startDate, $endDate);

        return [
            'name' => $fileName,
            'status' => $this->getTestCaseStatus($stepData),
            'start_date' => $startDate->format('Y-m-d h:i:s A'),
            'end_date'=> $endDateFormat,
            'duration'=> $interval->format('%im %ss %fms'),
            'steps'=> $stepData
        ];
    }

    public function getTestCaseStatus($stepData)
    {
        $statuses = array_column($stepData, 'status');

        switch ($statuses){
            case in_array('error', $statuses);
                $status = 'Error';
                break;
            case in_array('fail', $statuses);
                $status = 'Fail';
                break;
            case in_array('pass', $statuses);
                $status = 'Pass';
                break;
            default: {
                $status = '';
            }
        }

        return $status;
    }

    public function getStatusClass($status): string
    {
        switch ($status) {
            case 'Pass':
                $class = 'tfr-pass-border tfr-pass-color';
                break;
            case 'Fail':
                $class = 'tfr-fail-border tfr-fail-color';
                break;
            case 'Error':
                $class = 'tfr-error-border tfr-error-color';
                break;
            default:
                $class = 'border-dark tfr-error-color';
        }

        return $class;
    }
}
<?php

require_once "../../utils/ReportHandler.php";

$reportHandler = new ReportHandler();
$reportsStore = $reportHandler->initReportStore();

$reportId = $_GET['report'];
$report = $reportsStore->deleteById($reportId);

header('Location: ' . $_SERVER['HTTP_REFERER']);

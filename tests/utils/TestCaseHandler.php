<?php

use PHPUnit\Framework\TestCase;

class TestCaseHandler
{

    public function assertEquals($stepName, $actualValue, $exceptedValue)
    {
        $reportHandler = new ReportHandler();

        try {
            TestCase::assertEquals($actualValue, $exceptedValue);
            $message = "Actual value " . $actualValue . " is same as expected value " . $exceptedValue . ".";
            $_SESSION['stepData'][] = $reportHandler->getTestValidationData('pass', $stepName, $message);

        } catch (Exception $exception) {
            $message = "Actual value " . $actualValue . " is NOT the same as expected value " . $exceptedValue . ".";
            $_SESSION['stepData'][] = $reportHandler->getTestValidationData('fail', $stepName, $message);

        }
    }

    public function assertNotNull($stepName, $actualValue)
    {
        $reportHandler = new ReportHandler();

        try {
            TestCase::assertNotNull($actualValue);
            $message = "Given object " . $actualValue . " is not null" . ".";
            $_SESSION['stepData'][] = $reportHandler->getTestValidationData('pass', $stepName, $message);

        } catch (Exception $exception) {
            $_SESSION['stepData'][] = $reportHandler->getTestValidationData('fail', $stepName, $exception->getMessage());
        }
    }

    public function assertNull($stepName, $actualValue)
    {
        $reportHandler = new ReportHandler();

        try {
            TestCase::assertNotNull($actualValue);
            $message = "Given object is null.";
            $_SESSION['stepData'][] = $reportHandler->getTestValidationData('pass', $stepName, $message);

        } catch (Exception $exception) {
            $_SESSION['stepData'][] = $reportHandler->getTestValidationData('fail', $stepName, $exception->getMessage());
        }
    }

    public function assertTrue($stepName, $actualValue)
    {
        $reportHandler = new ReportHandler();

        try {
            TestCase::assertTrue($actualValue);
            $message = "Given value is true.";
            $_SESSION['stepData'][] = $reportHandler->getTestValidationData('pass', $stepName, $message);

        } catch (Exception $exception) {
            $_SESSION['stepData'][] = $reportHandler->getTestValidationData('fail', $stepName, $exception->getMessage());
        }
    }
}
<?php require_once "../utils/ReportHandler.php"; ?>
<?php include_once "includes/header.php"; ?>
<?php include_once "includes/navigation.php"; ?>

<?php
$reportHandler = new ReportHandler();
$reportsStore = $reportHandler->initReportStore();
$reportsStoreAll = $reportsStore->findAll(["report_id" => "desc"]);
?>

<div class="main-content container-fluid">
    <div class="border-bottom p-3">
        <h1 class="ms-3 mt-5 text-secondary">Reports</h1>
    </div>
    <div class="row">
        <div class="col-12 col-lg-9">
            <table class="table table-striped table-borderless ms-3 me-3 mt-3 tfr-report-table">
                <caption>Reports Table</caption>
                <thead>
                <tr class="text-secondary">
                    <th class="tfr-name">Name</th>
                    <th class="tfr-test-number">Number of tests</th>
                    <th class="tfr-test-type">Type</th>
                    <th class="tfr-test-indexes">Indexes</th>
                    <th class="tfr-test-file">File</th>
                    <th class="tfr-test-debug">Debug</th>
                    <th class="tfr-actions">Actions</th>
                    <th class="tfr-actions"></th>
                </tr>
                </thead>
                <tbody class="no-border-x">
                    <?php foreach($reportsStoreAll as $item): ?>
                        <tr>
                            <td><a class="link-dark" href="tests.php?report=<?php echo $item['report_id'] ?>"><?php echo $item['name'] ?></a></td>
                            <td class="tfr-test-number-value"><span class="badge rounded-pill tfr-clear-background-color"><?php echo $item['tests_number'] ?></span></td>
                            <td class="tfr-test-type-value"><span class="badge rounded-pill tfr-clear-background-color"><?php echo $item['options']['type'] ?? '' ?></span></td>
                            <td class="tfr-test-indexes-value" style="padding-left: 25px"><span class="badge rounded-pill tfr-clear-background-color"><?php echo $item['options']['indexes'] ?? 'all' ?></span></td>
                            <td class="tfr-test-file-value"><span class="badge rounded-pill tfr-clear-background-color"><?php echo $item['options']['file'] ?? '' ?></span></td>
                            <td class="tfr-test-debug-value" style="padding-left: 25px"><span class="badge rounded-pill tfr-clear-background-color"><?php echo $item['options']['debug'] ?? '' ?></span></td>
                            <td><a class="text-dark" href="controllers/delete.php?report=<?php echo $item['report_id'] ?>">delete</a></td>
                            <td><a class="text-dark" href="tests.php?report=<?php echo $item['report_id'] ?>">view</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-12 col-lg-6">
        </div>
    </div>
</div>
<?php include_once "includes/footer.php";?>


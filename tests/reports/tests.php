<?php require_once "../utils/ReportHandler.php"; ?>
<?php include_once "includes/header.php"; ?>
<?php include_once "includes/navigation.php"; ?>

<?php
$reportHandler = new ReportHandler();
$reportsStore = $reportHandler->initReportStore();
$reportId = $_GET['report'];
?>

<div class="d-flex align-items-stretch flex-shrink-0">
    <div class="tfr-container tfr-sidebar bg-white overflow-auto border-end">
        <div class="border-bottom p-3">
            <span class="fs-5 fw-semibold text-secondary">Tests</span>
        </div>
        <?php if (isset($reportId)): ?>
            <?php $report = $reportsStore->findById($reportId); ?>
            <ul class="tfr-test-list test-list-group list-group list-group-flush border-bottom">
                <?php foreach($report['report'] as $tests): ?>
                    <li class="tfr-test-id list-group-item list-group-item-action py-3 lh-tight" data-test-id="<?php echo $tests['_id'] ?>">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <span class="mb-1 text-break text-secondary" style="font-size: 13px;"><?php echo $tests['name'] ?></span>
                            <span class="badge tfr-border <?php echo $reportHandler->getStatusClass($tests['status']); ?>"><?php echo $tests['status'] ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <div class="tfr-container tfr-content main-content container-fluid overflow-auto"></div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {

        <!-- Render test view HTML -->
        renderTestView(<?php echo json_encode($report); ?>);

        // Hide filter feature temporary
        <!-- Render filtered test view history HTML -->
        // $('body').on('click', '.tfr-filter-container span', function() {
        //     status = $(this).attr("data-filter");
        //     renderHistoryByFilter(status);
        // });
    });
</script>

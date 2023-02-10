// Render test view based on report JSON
function renderTestView(report) {

    html = '';

    $('.tfr-test-id').on("click", function() {
        testId = $(this).attr("data-test-id");

        $(this).addClass('active').siblings().removeClass('active');

        $.each(report.report, function(reportKey, reportValue) {
            $.each(reportValue, function(testIndex, testItem) {

                if (reportValue._id == testId) {

                    // Build test view summary HTML
                    html = buildTestViewSummary(html, testIndex, testItem);

                    if (testIndex == 'steps') {

                        // Build test view table header HTML
                        html = buildTestViewTableHeader(html);

                        // Build test view table body HTML
                        html = buildTestViewTableBody(html, testItem);

                        // Add test item as data attribute
                        html = addTestItemAsDataAttribute(html, testItemObj = { data : testItem });

                        // Build test view table footer HTML
                        html = buildTestViewTableFooter(html);
                    }
                }
            });
        });

        // Append HTML
        insertHTML('.main-content');
    });

    // Click first test on page load
    clickFirstTestOnPageLoad();
}

// Build test view summary HTML
function buildTestViewSummary(html, testIndex, testItem) {

    if (testIndex == 'name') {
        html = '<div class="h4 text-secondary">' + testItem + '</div>';
    }

    if (testIndex == 'start_date') {
        html += '<div class="d-flex">';
        html += '<div class="test-timing flex-grow-1 bd-highlight mt-1 mb-5">'
        html += '<span class="badge tfr-pass-background-color me-1">' + testItem + '</span>';
    }

    if (testIndex == 'end_date') {
        html += '<span class="badge tfr-error-background-color me-1">' + testItem + '</span>';
    }
    if (testIndex == 'duration') {
        html += '<span class="badge tfr-clear-background-color">' + testItem + '</span>';
        html += '</div>'
        // Hide filter feature temporary
        // html += '<div class="tfr-filter-container mt-1 mb-5">'
        // html += '<span class="mx-1" data-filter="info"><i class="bi bi-info-circle tfr-filter-icon tfr-info-color"></i></span>'
        // html += '<span class="mx-1" data-filter="pass"><i class="bi bi-check-circle tfr-filter-icon tfr-pass-color"></i></span>'
        // html += '<span class="mx-1" data-filter="fail"><i class="bi bi-exclamation-circle tfr-filter-icon tfr-fail-color"></i></span>'
        // html += '<span class="mx-1" data-filter="error"><i class="bi bi-bug tfr-filter-icon tfr-error-color"></i></span>'
        // html += '<span class="mx-1" data-filter=""><i class="bi bi-backspace-reverse tfr-filter-icon tfr-clear-color"></i></span>'
        // html += '</div>'
        html += '</div>'
    }

    return html;
}

// Build test view table header HTML
function buildTestViewTableHeader(html) {

    html += '<table class="table tfr-test-table">';
    html += '<thead>';
    html += '<tr class="text-secondary">';
    html += '<th class="text-uppercase tfr-status-column" scope="col">Status</th>';
    html += '<th class="text-uppercase tfr-timestamp-column" scope="col">Timestamp</th>';
    html += '<th class="text-uppercase tfr-step-name-column" scope="col">Step name</th>';
    html += '<th class="text-uppercase tfr-step-details-column" scope="col">Details</th>';
    html += '</tr>';
    html += '</thead>';
    html += '<tbody class="tfr-filter-tbody">';

    return html;
}

// Build test view table body HTML
function buildTestViewTableBody(html, testItem, status = '') {

    $.each(testItem, function(stepsKey, stepsValue) {

        html += '<tr>';

        $.each(stepsValue, function(stepKey, stepValue) {

            if (!status) {
                if (stepKey === 'status') {
                    // Get status icon
                    statusIcon = getStatusIcon(stepValue);
                    html += '<td>' + statusIcon + '</td>';
                }

                if (stepKey === 'timestamp') {
                    html += '<td>' + stepValue + '</td>';
                }

                if (stepKey === 'step_name') {
                    html += '<td class="text-break">' + stepValue + '</td>';
                }

                if (stepKey === 'details') {
                    html += '<td class="text-break">' + JSON.stringify(stepValue) + '</td>';
                }
            } else if (stepsValue.status === status) {
                if (stepKey === 'status') {
                    // Get status icon
                    statusIcon = getStatusIcon(stepValue);
                    html += '<td>' + statusIcon + '</td>';
                }

                if (stepKey === 'timestamp') {
                    html += '<td>' + stepValue + '</td>';
                }

                if (stepKey === 'step_name') {
                    html += '<td class="text-break">' + stepValue + '</td>';
                }

                if (stepKey === 'details') {
                    html += '<td class="text-break">' + JSON.stringify(stepValue) + '</td>';
                }
            }
        });

        html += '</tr>';
    });

    return html;
}

// Add test item as data attribute
function addTestItemAsDataAttribute(html, testItem) {

    html += '<div id="data-item" data-test-item="data"></div>';

    return html;
}

// Build test view table footer HTML
function buildTestViewTableFooter(html) {

    html += '</tbody>';
    html += '</table>';

    return html;
}

// Append HTML
function insertHTML(identifier) {
    $(identifier).html(html);
}

// Click first test on page load
function clickFirstTestOnPageLoad() {
    $('.tfr-test-list li:first-child').trigger('click');
}

// Hide filter feature temporary
// Render filtered test view history HTML
// function renderHistoryByFilter(status) {
//
//     html = '';
//     html += buildTestViewTableBody(html, testItemObj['data'], status)
//
//     insertHTML('.tfr-filter-tbody');
// }

// Get status icon
function getStatusIcon(status) {

    switch (status) {
        case 'info':
            icon = '<i class="bi bi-info-circle tfr-filter-icon tfr-info-color"></i>'
            break;
        case 'pass':
            icon = '<i class="bi bi-check-circle tfr-filter-icon tfr-pass-color"></i>'
            break;
        case 'fail':
            icon = '<i class="bi bi-exclamation-circle tfr-filter-icon tfr-fail-color"></i>'
            break;
        case 'error':
            icon = '<i class="bi bi-bug tfr-filter-icon tfr-error-color"></i>'
            break;
        default:
            ''
    }
    return icon;

}
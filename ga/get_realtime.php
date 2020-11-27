<?PHP

 $optParams = array(
    'dimensions' => 'rt:medium');

try {
  $results = $analytics->data_realtime->get(
      'ga:118245634',
      'rt:activeUsers',
      $optParams);
  // Success. 
} catch (apiServiceException $e) {
  // Handle API service exceptions.
  $error = $e->getMessage();
}


printRealtimeReport($results);

/**
 * 2. Print out the Real-Time Data
 * The components of the report can be printed out as follows:
 */

function printRealtimeReport($results) {
  // printReportInfo($results);
  // printQueryInfo($results);
  // printProfileInfo($results);
  // printColumnHeaders($results);
  // printDataTable($results);
  printTotalsForAllResults($results);
}

function printDataTable(&$results) {

  if (count($results->getRows()) > 0) {
    $table = '<table>';

    // Print headers.
    $table .= '<tr>';

    foreach ($results->getColumnHeaders() as $header) {
      $table .= '<th>' . $header->name . '</th>';
    }
    $table .= '</tr>';

    // Print table rows.
    foreach ($results->getRows() as $row) {
      $table .= '<tr>';
        foreach ($row as $cell) {
          $table .= '<td>'
                 . htmlspecialchars($cell, ENT_NOQUOTES)
                 . '</td>';
        }
      $table .= '</tr>';
    }
    $table .= '</table>';

  } else {
    $table .= '<p>No Results Found.</p>';
  }
  print $table;
}

function printColumnHeaders(&$results) {
  $html = '';
  $headers = $results->getColumnHeaders();

  foreach ($headers as $header) {
    $html .= <<<HTML
<pre>
Column Name       = {$header->getName()}
Column Type       = {$header->getColumnType()}
Column Data Type  = {$header->getDataType()}
</pre>
HTML;
  }
  print $html;
}

function printProfileInfo(&$results) {
  $profileInfo = $results->getProfileInfo();

  $html = <<<HTML
<pre>
Account ID               = {$profileInfo->getAccountId()}
Web Property ID          = {$profileInfo->getWebPropertyId()}
Internal Web Property ID = {$profileInfo->getInternalWebPropertyId()}
Profile ID               = {$profileInfo->getProfileId()}
Profile Name             = {$profileInfo->getProfileName()}
Table ID                 = {$profileInfo->getTableId()}
</pre>
HTML;

  print $html;
}

function printReportInfo(&$results) {
  $html = <<<HTML
  <pre>
Kind                  = {$results->getKind()}
ID                    = {$results->getId()}
Self Link             = {$results->getSelfLink()}
Total Results         = {$results->getTotalResults()}
</pre>
HTML;

  print $html;
}

function printTotalsForAllResults(&$results) {
  $totals = $results->getTotalsForAllResults();

  foreach ($totals as $metricName => $metricTotal) {

    $html =$metricTotal;
  }

  print $html;
}
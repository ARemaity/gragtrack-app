
<?php
$report=create_report($analytics,'118245634');
printResults($report);
function create_report($analytics,$id){


  // Replace with your view ID, for example XXXX.
  $VIEW_ID = $id;
  // $VIEW_ID = "227162231";
  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("7daysAgo");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:sessions");
  $sessions->setAlias("sessions");

//Create the Dimensions object.
$browser = new Google_Service_AnalyticsReporting_Dimension();
$browser->setName("ga:browser");




  // Create Dimension Filter.
  $dimensionFilter = new Google_Service_AnalyticsReporting_DimensionFilter();
  $dimensionFilter->setDimensionName("ga:browser");
  $dimensionFilter->setOperator("EXACT");
  $dimensionFilter->setExpressions(array("Safari"));

  $dimensionFilterClause = new Google_Service_AnalyticsReporting_DimensionFilterClause();
  $dimensionFilterClause->setFilters(array($dimensionFilter));
  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setDimensions(array($browser));
  $request->setDimensionFilterClauses(array($dimensionFilterClause));
  $request->setMetrics(array($sessions));

//   $request->setDimensionFilterClauses(array($dimensionFilter));
  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request));
  return $analytics->reports->batchGet( $body);

}
/**
 * Parses and prints the Analytics Reporting API V4 response.
 *
 * @param An Analytics Reporting API V4 response.
 */
function printResults($reports) {


      for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
        $report = $reports[ $reportIndex ];
        $header = $report->getColumnHeader();
        $dimensionHeaders = $header->getDimensions();
        $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
        $rows = $report->getData()->getRows();
        for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
          $row = $rows[ $rowIndex ];
          $dimensions = $row->getDimensions();
          $metrics = $row->getMetrics();
          for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
            print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
          }
    
          for ($j = 0; $j < count($metrics); $j++) {
            $values = $metrics[$j]->getValues();
            for ($k = 0; $k < count($values); $k++) {
              $entry = $metricHeaders[$k];
              print($entry->getName() . ": " . $values[$k] . "\n");
            }
          }
        }
      }
    }



?>
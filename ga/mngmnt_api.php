

<?php
try {
  $accounts = $analytics->management_accountSummaries
      ->listManagementAccountSummaries();
} catch (apiServiceException $e) {
  print 'There was an Analytics API service error '
        . $e->getCode() . ':' . $e->getMessage();

} catch (apiException $e) {
  print 'There was a general API error '
      . $e->getCode() . ':' . $e->getMessage();
}

/**
 * Example #2:
 * The results of the list method are stored in the accounts object.
 * The following code shows how to iterate through them.
 */
foreach ($accounts->getItems() as $account) {
  $html = <<<HTML
<pre>
Account id   = {$account->getId()}
Account kind = {$account->getKind()}
Account name = {$account->getName()}
HTML;

  // Iterate through each Property.
  foreach ($account->getWebProperties() as $property) {
    $html .= <<<HTML
Property id          = {$property->getId()}
Property kind        = {$property->getKind()}
Property name        = {$property->getName()}
Internal property id = {$property->getInternalWebPropertyId()}
Property level       = {$property->getLevel()}
Property URL         = {$property->getWebsiteUrl()}
HTML;

    // Iterate through each view (profile).
    foreach ($property->getProfiles() as $profile) {
      $html .= <<<HTML
Profile id   = {$profile->getId()}
Profile kind = {$profile->getKind()}
Profile name = {$profile->getName()}
Profile type = {$profile->getType()}
HTML;
    }
  }
  $html .= '</pre>';
  print $html;
}
?>
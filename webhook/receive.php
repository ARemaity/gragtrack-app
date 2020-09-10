<?php

// Load variables
$webhook_content = NULL;

// Get webhook content from the POST
$webhook = fopen('php://input' , 'rb');
while (!feof($webhook)) {
  $webhook_content .= fread($webhook, 4096);
}
fclose($webhook);

// Decode Shopify POST
$webhook_content = json_decode($webhook_content, TRUE);

// Get the total items ordered
$total_items_ordered = count($webhook_content['line_items']);

// Is the customer a VIP?
if ($total_items_ordered >= 3) {

  // Yes, they are
  $vip_customer = TRUE;

} else {

  // No, they're not
  $vip_customer = FALSE;

}

?>
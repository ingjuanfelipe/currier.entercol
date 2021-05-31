<?php

// Set variables for our request
//$shop = $_GET['shop'];
$api_key = "2e0e9e7241609205013bc4ce6f1a84f6";//"1r30mrvCFMfq2DLGuIXyY2veEJVgTtDD";
$scopes = "read_orders,write_products";
$redirect_uri = "https://currier.entercol.com/generate_token.php";

// Build install/approval URL to redirect to
//$install_url = "https://" . $shop . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);
$install_url = "https://othersideuy.myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();
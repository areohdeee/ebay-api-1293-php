<?php


// eBay API 1293 GetItemStatus call in PHP - 2023 areohdeee

ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
error_reporting( E_ALL );

// function to generate oauth creds and base64 encode them.
function getOAuthCreds() {

  // you need the ':' in the next line
  $userPass = "YOUR-App-ID-Client-ID:YOUR-Cert-ID-Client-Secret";

  $endpoint = 'https://api.ebay.com/identity/v1/oauth2/token';

  $request = "grant_type=client_credentials&scope=https://api.ebay.com/oauth/api_scope";

  $session = curl_init( $endpoint );

  curl_setopt( $session, CURLOPT_POST, true );
  curl_setopt( $session, CURLOPT_POSTFIELDS, $request );
  curl_setopt( $session, CURLOPT_RETURNTRANSFER, true );

  $headers = [
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization: Basic ' . base64_encode( $userPass )
  ];

  curl_setopt( $session, CURLOPT_HTTPHEADER, $headers );
  $response = curl_exec( $session );
  curl_close( $session );
  return $response;
}


// make the call in curl
// replace EBAYITEMID with real ebay item ids
// you can request up to 20 ebay item ids at a time
$curl = curl_init();
curl_setopt_array( $curl, array(
  CURLOPT_URL => "https://open.api.ebay.com/shopping?callname=GetItemStatus&responseencoding=JSON&siteid=0&version=967&IncludeSelector=Details&ItemID=EBAYITEMID,EBAYITEMID,EBAYITEMID",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Content-Type:application/json",
    "X-EBAY-API-IAF-TOKEN: " . getOAuthCreds() . "",
    "User-Agent:PHP"
  ),
) );
$response = curl_exec( $curl );
$err = curl_error( $curl );
curl_close( $curl );


// display response
echo "<pre>";
print_r( $response );
echo "</pre>";

?>
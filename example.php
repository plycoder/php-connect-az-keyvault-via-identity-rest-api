<?php
error_reporting(E_ALL);
require_once  "appClasses/azure/FetchAzureVaultDataViaCurl.php";

$azvault=new FetchAzureVaultDataViaCurl("https://plycoder-dev-testing-kv.vault.azure.net");

echo "<br/>fetch secret:<br/>";
$pubkey=$azvault->getSecret("pubkey")->value;

echo "<br/>pubkey<br/>";
echo $pubkey;


echo "<br/>fetch key:<br/>";
$privatekey=$azvault->getKey("privatekey");

echo $privatekey->type."<br/>"; // e.g. "RSA"
echo $privatekey->n."<br/>";    // prints base64 encoded RSA modulus
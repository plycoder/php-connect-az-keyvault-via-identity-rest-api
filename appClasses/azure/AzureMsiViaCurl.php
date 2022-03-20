<?php
/**
 * 
 */

require_once  "appClasses/exception/AzureException.php";
require_once  "appClasses/curl/PhpCurl.php";
require_once  "appClasses/azure/FetchAzureVaultDataViaCurl.php";


class AzureMsiViaCurl{
    protected $azure_auth_url="http://169.254.169.254/metadata/identity/oauth2/token";
    protected $resource = 'https://vault.azure.net';
	protected $api_version = '2019-08-01';


    /** @var Curl\Curl */
    protected $curl;
    protected $header;

    public function __construct() {
        $this->curl = new PhpCurl();
    }


    public function getMsiAccessToken(){
        $data=[
            'resource' => $this->resource,
            'api-version' => $this->api_version
        ];

                
        $endpoint = $this->env('IDENTITY_ENDPOINT', $this->azure_auth_url);
        $idHeaderValue = $this->env('IDENTITY_HEADER', 'true');
        $idHeaderName = !empty($this->env('IDENTITY_HEADER')) ? 'X-IDENTITY-HEADER' : 'Metadata';

        $this->header=array("$idHeaderName: $idHeaderValue");


       $response= $this->curl->curlGet($endpoint,$data,$this->header);
       

       if(isset($response->access_token)){
           return $response->access_token;
       }else{
           throw new AzureException(print_r($response,true));
       }
      
    }


    private function env(string $name, string $fallback = '') {
        $value = getenv($name);
        return $value !== false ? $value : $fallback;
    }



}
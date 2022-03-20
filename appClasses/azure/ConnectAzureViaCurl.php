<?php
/**
 * 
 */

require_once  "appClasses/exception/AzureException.php";
require_once  "appClasses/curl/PhpCurl.php";


class ConnectAzureViaCurl{

    protected $azure_auth_url="https://login.microsoftonline.com/replace_with_tenant_info/oauth2/token";
	protected $grant_type='client_credentials';
	protected $client_id ='a2026efd-ce18-44a2-88bf-d0271c38525c';
	protected $client_secret = 'JGR7Q~N5Hy8N_vb~f4o8GHvQA~TBWizk3oBlT';
	protected $resource = 'https://vault.azure.net';
	protected $tenant_info = 'e8bff4c2-7468-4ee4-907f-d5beab710af9';
	protected $api_version = '2019-08-01';


    /** @var Curl\Curl */
    protected $curl;
    protected $bearer_token;

    public function __construct() {
        $this->curl = new PhpCurl();
    }


    public function getAccessToken(){
        $data=[
            'grant_type' =>  $this->grant_type,
            'client_id' =>  $this->client_id,
            'client_secret' =>  $this->client_secret,
            'resource' => $this->resource,
            'api-version' => $this->resource
        ];

       $url_with_tenant_info=$this->urlWithTenantInfo($this->tenant_info,$this->azure_auth_url); 
       $response= $this->curl->curlPost($url_with_tenant_info,$data);
       
       $response_obj=json_decode($response);

       if(isset($response_obj->access_token)){
           return $response_obj->access_token;
       }else{
           throw new AzureException(print_r($response_obj,true));
       }
      
    }

    private function urlWithTenantInfo($tenant_info,$url){
        return str_replace("replace_with_tenant_info",$tenant_info,$url); 
    }


}
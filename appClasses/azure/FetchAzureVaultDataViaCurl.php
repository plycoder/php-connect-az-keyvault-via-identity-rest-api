<?php
/**
 * 
 */

require_once  "appClasses/exception/AzureException.php";
require_once  "appClasses/curl/PhpCurl.php";
require_once  "appClasses/azure/AzureMsiViaCurl.php";


class FetchAzureVaultDataViaCurl{

    protected $curl;
    protected $header;
    protected $vault_url;
    protected $azrest;
    protected $token;
    protected $api_version="7.0";
    

    public function __construct($url) {
        $this->curl = new PhpCurl();
        $this->azrest=new AzureMsiViaCurl();
        $this->vault_url=$url;
        $this->token=$this->azrest->getMsiAccessToken();
        
    }


    public function getVaultData(){
       $this->token=$this->azrest->getMsiAccessToken(); 
       $this->header=array("Authorization: Bearer ".$this->token,"content-type: application/json");
       $response= $this->curl->curlGet($this->vault_url,null,$this->header);
       return $response;
    }
	
	
	public function getSecret($secret,$version=null){
		
		$this->header=array("Authorization: Bearer ".$this->token,"content-type: application/json");
        $secret_url=$this->vault_url."/secrets/".$secret.(!empty($version)?"/".$version:"");
		$data=[
            'api-version'=>'7.0'
        ];
        $response= $this->curl->curlGet($secret_url,$data,$this->header);
		
		return $response;
	}
	
	public function getSecrets(){
		
		$this->header=array("Authorization: Bearer ".$this->token,"content-type: application/json");
        $secret_url=$this->vault_url."/secrets/";
		$data=[
            'api-version'=>'7.0'
        ];
        $response= $this->curl->curlGet($secret_url,$data,$this->header);
		
		return $response;
	}
	
	public function getKey($key,$keyVersion=null){

        $data=[
            'api-version'=>'7.0'
        ];
        $this->header=array("Authorization: Bearer ".$this->token,"content-type: application/json");
        $key_url=$this->vault_url."/keys/".$key.(!empty($version)?"/".$version:"");
        $response= $this->curl->curlGet($key_url,$data,$this->header);

       return $response;


    }






}
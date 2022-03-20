<?php
/**
 * 
 */
require_once  "appClasses/exception/AzureException.php";


class PhpCurl{
    protected $curl;
    protected $err;
    protected $response;
    public function __construct() {
        $this->curl =  curl_init();
    }

    public function curlPost($url,$post_data_array){
        $postdata = http_build_query($post_data_array);
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 60,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postdata,
            CURLOPT_HTTPHEADER => array(
              "content-type: application/x-www-form-urlencoded"
            ),
          ));

        $this->response = curl_exec($this->curl);
        $this->err = curl_error($this->curl);
    
    
        if ($this->err) {
            throw new AzureException('Curl error:'.$this->err);
        }else {
           return  $this->response;
        }

    }


    public function curlGet($url,$get_data_array=null,$header){

        if(!empty($get_data_array)){
            $data = http_build_query($get_data_array);
            $url = $url."?".$data;
        }


        curl_setopt_array($this->curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 60,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => $header,
          ));

          $this->response = curl_exec($this->curl);
          $this->err = curl_error($this->curl);
      
          

          if ($this->err) {
              throw new AzureException('Curl error:'.$this->err);
          }else {
             return  json_decode($this->response);
          }
        

    }

}
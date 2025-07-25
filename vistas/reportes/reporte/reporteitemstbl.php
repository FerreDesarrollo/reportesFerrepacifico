<?php
// Verifica si el parámetro 'parametro1' ha sido enviado



	function clientes($sql){
        if (!defined('NETSUITE_DEPLOYMENT_URL')) {
            define("NETSUITE_DEPLOYMENT_URL", 'https://5017898.restlets.api.netsuite.com/app/site/hosting/restlet.nl?script=1376&deploy=1');
        }
        if (!defined('NETSUITE_URL')) {
            define("NETSUITE_URL", 'https://5017898..restletsapi.netsuite.com');
        }
        if (!defined('NETSUITE_REST_URL')) {
            define("NETSUITE_REST_URL", 'https://5017898.restlets.api.netsuite.com/app/site/hosting/restlet.nl');
        }
        if (!defined('NETSUITE_SCRIPT_ID')) {
            define("NETSUITE_SCRIPT_ID", '1376');
        }
        if (!defined('NETSUITE_DEPLOY_ID')) {
            define("NETSUITE_DEPLOY_ID", '1');
        }
        if (!defined('NETSUITE_ACCOUNT')) {
            define("NETSUITE_ACCOUNT", '5017898');
        }
        if (!defined('NETSUITE_CONSUMER_KEY')) {
            define("NETSUITE_CONSUMER_KEY", '4a8b80dd03087c6b3e7ffa5c6f2bb1dc55de7c14b43f4785e5efe3d2b38cf323');
        }
        if (!defined('NETSUITE_CONSUMER_SECRET')) {
            define("NETSUITE_CONSUMER_SECRET", 'a1560b11b878ab97e492eab1ac2c235370a23ab0c6f426a699d9e32ec42412ed');
        }
        if (!defined('NETSUITE_TOKEN_ID')) {
            define("NETSUITE_TOKEN_ID", '3ff82fb87941c6287268a66db5c1d54fc7af6ad556cc8d0f6154d7b0b393b87a');
        }
        if (!defined('NETSUITE_TOKEN_SECRET')) {
            define("NETSUITE_TOKEN_SECRET", '6d4475bb3addd3a581e50dd001d5114189a5fcea981c8b05408eaa222a8b364c');
        }
        
        
        $encoded = json_encode($sql);
        $data_string = $encoded;
        $oauth_nonce = md5(mt_rand());
        $oauth_timestamp = time();
        $oauth_signature_method = 'HMAC-SHA256';
        $oauth_version = "1.0";
        
        $base_string =
            "POST&".urlencode(NETSUITE_REST_URL)."&".
                urlencode(
                    "deploy=".NETSUITE_DEPLOY_ID
                        ."&oauth_consumer_key=".NETSUITE_CONSUMER_KEY
                    ."&oauth_nonce=".$oauth_nonce
                    ."&oauth_signature_method=".$oauth_signature_method
                    ."&oauth_timestamp=".$oauth_timestamp
                    ."&oauth_token=".NETSUITE_TOKEN_ID
                    ."&oauth_version=".$oauth_version
                    ."&script=".NETSUITE_SCRIPT_ID
                );
        
        $key = rawurlencode(NETSUITE_CONSUMER_SECRET).'&'.rawurlencode(NETSUITE_TOKEN_SECRET);
        $signature = base64_encode(hash_hmac("sha256", $base_string, $key, true));
        $auth_header = 'OAuth '
            .'realm="'.rawurlencode(NETSUITE_ACCOUNT).'",'
                .'oauth_consumer_key="'.rawurlencode(NETSUITE_CONSUMER_KEY).'",'
                    .'oauth_token="'.rawurlencode(NETSUITE_TOKEN_ID).'",'
                        .'oauth_signature_method="'.rawurlencode($oauth_signature_method).'",'
                            .'oauth_timestamp="'.rawurlencode($oauth_timestamp).'",'
                                .'oauth_nonce="'.rawurlencode($oauth_nonce).'",'
                                    .'oauth_version="'.rawurlencode($oauth_version).'",'
                                        .'oauth_signature="'.rawurlencode($signature).'"';
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => NETSUITE_DEPLOYMENT_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data_string,
            CURLOPT_HTTPHEADER => array(
                'Authorization: '.$auth_header,
                'Content-Type: application/json'
            ),
        ));
    
        $response = curl_exec($curl);
    
        curl_close($curl);
        return $response;
    }
  
	$c=array();
 $tipo_Filtro="";

        // Asigna el valor del parámetro 'parametro1' a la variable $parametro1
        $parametro1 = $_GET['parametro1'];
        
          
	$obj = clientes([ "consulta" =>"Consult_imagen","upc"=>$parametro1,]);
	$obj=json_decode($obj);
	for ($i=0; $i < count($obj); $i++) { 
		$clientes1=$obj[$i];
		for ($ii=0; $ii < count($clientes1); $ii++) { 
			$array = array();
			
			if(isset($clientes1[$ii]->{'codigo'})){
				$id=$clientes1[$ii]->{'codigo'};
				$nombre=$clientes1[$ii]->{'articulo'};
                $imagen = $clientes1[$ii]->{'imagen'};
                $unidad = $clientes1[$ii]->{'unidad'};
                
                $imagen2 = "https://5017898.app.netsuite.com" . $imagen;
                //https://5017898.app.netsuite.com/
				//$nombre = $db->caracters($nombre);
				array_push($c,"".$id." //T// ".$nombre."//T//  ".$imagen2."//T//  ".$unidad."");
			}
			
		} 
		
	}
	print_r(json_encode($c));

                                                             
                                                     
?>
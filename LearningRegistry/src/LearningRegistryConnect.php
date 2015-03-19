<?PHP

	namespace LearningRegistry;

	class LearningRegistryConnect{
	
		function __construct(){
		}
		
		function create_body(){
		
			$opt_id_fields = array(
				'curator',
				'owner',
				'signer',
			);

			$opt_res_fields = array(
				'submitter_timestamp',
				'submitter_TTL',
				'keys',
				'resource_TTL',
				'payload_schema_locator',
				'payload_schema_format',
			);

			$opt_sig_fields = array(
				'signature',
				'key_server',
				'key_locations',
				'key_owner',
				'signing_method',
			);

			$opt_tos_fields = array(
				'tos_submission_attribution',
			);
			
			// Make some parts of the PHP data structure
			
			$content_info = array();
			
			// Optional identity values.
			foreach ($opt_id_fields as $field) {
				if (array_key_exists($field, $content_info)) {
					$identity->$field = $content_info[$field];
				}
			}

			// Optional resource_data values.
			foreach ($opt_res_fields as $field) {
				if (array_key_exists($field, $content_info)) {
					$resource_data->$field = $content_info[$field];
				}
			}

			// Optional TOS values.
			foreach ($opt_tos_fields as $field) {
				if (array_key_exists($field, $content_info)) {
					$tos->$field = $content_info[$field];
				}
			}
			
			// Now the data structure is sort of finished, so add in some extra bits

			$content_info['resource_locator'] = "wibble.org"; 
			$content_info['resource_data_type'] = 'metadata'; 
			$content_info['submitter'] = "info@pgogywebstuff.com"; 
			$tos = "None provided";
			$content_info['tos'] = $tos;
			$content_info['curator'] = "info@pgogywebstuff.com"; 
			$content_info['active' ] = TRUE; 
			$content_info['payload_schema'] = 'DC 1.1'; 
			$content_info['payload_placement'] = 'inline';  
			
			$identity = new \StdClass();
			$resource_data = new \StdClass();
			
			$identity->submitter_type = 'user';
			$identity->submitter = $content_info['submitter'];
			
			$tos = new \StdClass;

			$tos->submission_TOS = $content_info['tos'];

			
			$resource_data->doc_type = 'resource_data';
			$resource_data->doc_version = "0.49.0";
			$resource_data->resource_data_type = $content_info['resource_data_type'];
			$resource_data->active = $content_info['active'];
			$resource_data->identity = $identity;
			$resource_data->TOS = $tos;

			$resource_data->resource_locator = $content_info['resource_locator'];
			$resource_data->payload_schema = array($content_info['payload_schema']);
			$resource_data->payload_placement = "inline";
			$resource_data->resource_data = htmlspecialchars_decode("");
			
			$keys = "lrphptest";
			
			$resource_data->keys = explode(",",$keys);
			
			$submission = new \StdClass;
			
			$submission->documents[] = $resource_data;
			
			$data_to_send = json_encode($submission);
			
			return $data_to_send;
			
		}
		
		function create_update_body(){
		
			$opt_id_fields = array(
				'curator',
				'owner',
				'signer',
			);

			$opt_res_fields = array(
				'submitter_timestamp',
				'submitter_TTL',
				'keys',
				'resource_TTL',
				'payload_schema_locator',
				'payload_schema_format',
			);

			$opt_sig_fields = array(
				'signature',
				'key_server',
				'key_locations',
				'key_owner',
				'signing_method',
			);

			$opt_tos_fields = array(
				'tos_submission_attribution',
			);
			
			// Make some parts of the PHP data structure
			
			$content_info = array();
			
			// Optional identity values.
			foreach ($opt_id_fields as $field) {
				if (array_key_exists($field, $content_info)) {
					$identity->$field = $content_info[$field];
				}
			}

			// Optional resource_data values.
			foreach ($opt_res_fields as $field) {
				if (array_key_exists($field, $content_info)) {
					$resource_data->$field = $content_info[$field];
				}
			}

			// Optional TOS values.
			foreach ($opt_tos_fields as $field) {
				if (array_key_exists($field, $content_info)) {
					$tos->$field = $content_info[$field];
				}
			}
			
			// Now the data structure is sort of finished, so add in some extra bits

			$content_info['resource_locator'] = "wibble.org"; 
			$content_info['resource_data_type'] = 'metadata'; 
			$content_info['submitter'] = "info@pgogywebstuff.com"; 
			$tos = "None provided";
			$content_info['tos'] = $tos;
			$content_info['curator'] = "info@pgogywebstuff.com"; 
			$content_info['active' ] = TRUE; 
			$content_info['payload_schema'] = 'DC 1.1'; 
			$content_info['payload_placement'] = 'inline';  
			
			$identity = new \StdClass();
			$resource_data = new \StdClass();
			
			$identity->submitter_type = 'user';
			$identity->submitter = $content_info['submitter'];
			
			$tos = new \StdClass;

			$tos->submission_TOS = $content_info['tos'];

			
			$resource_data->doc_type = 'resource_data';
			$resource_data->replaces = array('e7fa4e925b7c4057a8951fb6168d4123');
			$resource_data->doc_version = "0.49.0";
			$resource_data->resource_data_type = $content_info['resource_data_type'];
			$resource_data->active = $content_info['active'];
			$resource_data->identity = $identity;
			$resource_data->TOS = $tos;

			$resource_data->resource_locator = $content_info['resource_locator'];
			$resource_data->payload_schema = array($content_info['payload_schema']);
			$resource_data->payload_placement = "inline";
			$resource_data->resource_data = htmlspecialchars_decode("");
			
			$keys = "lrphptest";
			
			$resource_data->keys = explode(",",$keys);
			
			$submission = new \StdClass;
			
			$submission->documents[] = $resource_data;
			
			$data_to_send = json_encode($submission);
			
			return $data_to_send;
			
		}
		
		
		function delete_body($ids){

			$submission = new \StdClass;
			
			$submission->request_ids[] = $ids;
			
			$data_to_send = json_encode($submission);
			
			return $data_to_send;
			
		}
			
		function publish(){

			// Session storage
			$storage = new \OAuth\Common\Storage\Session();

			// Setup the credentials for the requests
			$credentials = new \OAuth\Common\Consumer\Credentials(
				"key",
				"secret",
				""
			);
			
			$httpClient = new LearningRegistryHTTPClient();

			$LROAuth = new LearningRegistryOAuth(
				    $credentials,
					$httpClient,
					$storage		
			);
			
			$interface = new LearningRegistryUri();
			$interface->setHost("http://sandbox.learningregistry.org/");
			$interface->setPath("publish");
			
			$extraHeaders = array(
								'Content-type' => 'application/json',
								'Authorization' => 'OAuth ' . base64_encode('oauth_consumer_key=info@pgogywebstuff.com'
																			. '&oauth_signature_method=RSA-SHA1'
																			. '&oauth_signature=wOJIO9A2W5mFwDgiDvZbTSMK%2FPY%3D'
																			. '&oauth_nonce=4572616e48616d6d65724c61686176')
							);
			
			$LROAuth->request(
								$interface,
								"POST",
								$this->create_body(),
								$extraHeaders	
							);
			
		}
		
		function update(){

			// Session storage
			$storage = new \OAuth\Common\Storage\Session();

			// Setup the credentials for the requests
			$credentials = new \OAuth\Common\Consumer\Credentials(
				"key",
				"secret",
				""
			);
			
			$httpClient = new LearningRegistryHTTPClient();

			$LROAuth = new LearningRegistryOAuth(
				    $credentials,
					$httpClient,
					$storage		
			);
			
			$interface = new LearningRegistryUri();
			$interface->setHost("http://sandbox.learningregistry.org/");
			$interface->setPath("publish");
			
			$extraHeaders = array(
								'Content-type' => 'application/json',
								'Authorization' => 'OAuth ' . base64_encode('oauth_consumer_key=info@pgogywebstuff.com'
																			. '&oauth_signature_method=RSA-SHA1'
																			. '&oauth_signature=wOJIO9A2W5mFwDgiDvZbTSMK%2FPY%3D'
																			. '&oauth_nonce=4572616e48616d6d65724c61686176')
							);
			
			$LROAuth->request(
								$interface,
								"POST",
								$this->create_update_body(),
								$extraHeaders	
							);
			
		}
		
		function status(){

			// Session storage
			$storage = new \OAuth\Common\Storage\Session();

			// Setup the credentials for the requests
			$credentials = new \OAuth\Common\Consumer\Credentials(null,null,null);
			
			$httpClient = new LearningRegistryHTTPClient();

			$LROAuth = new LearningRegistryOAuth(
				    $credentials,
					$httpClient,
					$storage		
			);
			
			$interface = new LearningRegistryUri();
			$interface->setHost("http://sandbox.learningregistry.org/");
			$interface->setPath("status");
			
			$LROAuth->request(
								$interface,
								"GET"
							);
			
		}
		
		function swordservice(){
		
			// Session storage
			$storage = new \OAuth\Common\Storage\Session();

			// Setup the credentials for the requests
			$credentials = new \OAuth\Common\Consumer\Credentials(null,null,null);
			
			$httpClient = new LearningRegistryHTTPClient();

			$LROAuth = new LearningRegistryOAuth(
				    $credentials,
					$httpClient,
					$storage		
			);
			
			$interface = new LearningRegistryUri();
			$interface->setHost("http://sandbox.learningregistry.org/");
			$interface->setPath("swordservice");
			
			$extraHeaders = array(
								'X-On-Behalf-Of' => 'on-behalf-of-user'
							);
			
			$LROAuth->request(
								$interface,
								"GET",
								null,
								$extraHeaders
							);
	
		}
		
		function delete($ids){

			// Session storage
			$storage = new \OAuth\Common\Storage\Session();

			// Setup the credentials for the requests
			$credentials = new \OAuth\Common\Consumer\Credentials(
				"key",
				"secret",
				""
			);
			
			$httpClient = new LearningRegistryHTTPClient();

			$LROAuth = new LearningRegistryOAuth(
				    $credentials,
					$httpClient,
					$storage		
			);
			
			$interface = new LearningRegistryUri();
			$interface->setHost("http://sandbox.learningregistry.org/");
			$interface->setPath("delete");
			
			$LROAuth->request(
								$interface,
								"POST",
								$this->delete_body($ids)
							);
			
		}
		
		
		
		function sign_document(){
		
			$wkey = \OpenPGP\Message::parse(file_get_contents("c:/users/Pat/AppData/Roaming/gnupg/pubring.gpg"));
			/* Create a new literal data packet */
			$data = new \OpenPGP\Packets\LiteralDataPacket('This is text.', array());
			/* Create a signer from the key */
			$RSA = new \OpenPGP\Crypt\RSA($wkey);
			
			$wkey->packets[0]->key['d'] = $wkey->packets[0]->key['e'];
			$wkey->packets[0]->key['p'] = $wkey->packets[0]->key['e'];
			$wkey->packets[0]->key['q'] = $wkey->packets[0]->key['e'];
			$wkey->packets[0]->key['u'] = $wkey->packets[0]->key['e'];
			
			$m = $RSA->sign("hello I am some content");
			
			echo $m->to_bytes();
			
		}
		
		function connect($url){
		
			$client = new \GuzzleHttp\Client();			
			$res = $client->get($url, 
				[
					'config' => [
						'curl' => [
							CURLOPT_SSL_VERIFYHOST => false,
							CURLOPT_SSL_VERIFYPEER => false,
						]
					]
				]
			);
			echo $res->getStatusCode();
			// "200"
			echo $res->getHeader('content-type');
			// 'application/json; charset=utf8'
			echo $res->getBody();
		}
	
	}
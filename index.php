<?PHP

require dirname(__FILE__) . "/vendor/autoload.php";
require dirname(__FILE__) . "/Psr4AutoloaderClass.php";

// Pass config an array of parameters, a json string or a file (see root of github for example files - just send it the path
$LRConfig = new LearningRegistry\LearningRegistryConfig();

$LR = new LearningRegistry\LearningRegistryServices\LearningRegistryPublish($LRConfig);
if($LR->checkNode()){
	if($LR->checkNodeActive()){
		
		$LR->setIdFields(
			array(
				//'curator' => "",
				//'owner' => "",
				//'signer' => "",
				'submitter_type' => "user", 
				'submitter' => "info@pgogywebstuff.com"
			)
		);
		
		$LR->setResFields(
			array(
				'resource_locator' => "www.test.com",
				'resource_data_type' => 'metadata', 
				'active' => TRUE,
				'replaces' => array('27a5d1852fb24d98bc731578d92cd155'),
				//'submitter_timestamp' => "",
				//'submitter_TTL' => "",
				//'resource_TTL' => "",
				//'payload_schema_locator' => "",
				//'payload_schema_format' => "",
				'doc_type' => 'resource_data',
				'doc_version' => '0.49.0',
				'payload_placement' => 'inline',
				'payload_schema' => array('DC 1.1'),
				'resource_data' => htmlspecialchars_decode("package"),
				//'keys' => array()
			)
		);
		
		$LR->setSigFields(
			array(
				'signature'  => "",
				'key_server'  => "",
				'key_locations'  => "",
				'key_owner'  => "",
				'signing_method'  => "",
			)
		);
		
		$LR->setTosFields(
			array(
				//'tos_submission_attribution' => "",
				'submission_TOS' => "Standard",
			)
		);
		
		$LR->createDocument();
		if($LR->verifyDocument()){
			$LR->formatDocument();
			$LR->PublishService();
			echo $LR->getDocID();
		}
		
	}else{
		print_r($LR->getResponse());
	}
}else{
	print_r($LR->getResponse());
}
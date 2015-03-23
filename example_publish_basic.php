<?PHP

require dirname(__FILE__) . "/vendor/autoload.php";
require dirname(__FILE__) . "/Psr4AutoloaderClass.php";

$LRConfig = new LearningRegistry\LearningRegistryConfig(
                                                           array(
														     "url" => "sandbox.learningregistry.org", //ul
														     "username" => "info@pgogywebstuff.com", //username
														     "https" => 1, //whether the use https
														     "signing" => 0, //sign or not sign
														     "password" => "Fearher0!", // passowrd
														     "oauthSignature" => "wOJIO9A2W5mFwDgiDvZbTSMK%2FPY%3D", // oauth signature
														     "auth" => "oauth", // use oauth or basic
														     "keyPath" => "c:/users/Pat/AppData/Roaming/gnupg/pubring.gpg", // path to key file
														     "publicKeyPath" => "http://www.pgogywebstuff.com/public_key.txt" // url for public key
														   )
);

// Create a new service (publish means we want to publish)

$LR = new LearningRegistry\LearningRegistryServices\LearningRegistryPublish($LRConfig);

// Check the node exists (optional)

//if($LR->checkNode()){

// Check the node is active (optional)

  //if($LR->checkNodeActive()){
    
	// Set the id fields - can be done one parameter at a time
	
    $LR->setIdFields(
      array(
        'curator' => "info@pgogywebstuff.com",
        'owner' => "info@pgogywebstuff.com",
        'signer' => "info@pgogywebstuff.com",
        'submitter_type' => "user", 
        'submitter' => "info@pgogywebstuff.com"
      )
    );
    
	// Set the resource fields - can be done one parameter at a time
	
    $LR->setResFields(
      array(
        'resource_locator' => "www.wibble.com", //url goes here
        'resource_data_type' => 'metadata', 
        'active' => TRUE,
        //'submitter_timestamp' => "",
        //'submitter_TTL' => "",
        //'resource_TTL' => "",
        //'payload_schema_locator' => "",
        //'payload_schema_format' => "",
        'doc_type' => 'resource_data',
        'doc_version' => '0.49.0',
        'payload_placement' => 'inline',
        'payload_schema' => array('DC 1.1'),
        'keys' => array() // add keys here
      )
    );
    
    $LR->setSigFields(
      array(
        'signature'  => "", // mostly set later if signing needed - here now for reference
        'key_server'  => "",
        'key_location'  => "",
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
    
	$LR->setResFields(
		array(
			'resource_data' => htmlspecialchars_decode("I am some data"), // setting the resource data
		)
	  );
	  
	
	// Turn the arrays above into a document
    $LR->createDocument();
	
	// Verify the document is ok (optional)
	
    if($LR->verifyDocument()){
	
	  // make the document into LR format and ready
	
	  $LR->finaliseDocument();
	  
	  // send the document
	  
	  $LR->PublishService();
	  echo "the response code is " . $LR->getStatusCode() . "<br />";
	  echo "the doc ID is " . $LR->getDocID() . "<br />";
    }
    
//  }
  
//}
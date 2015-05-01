<?PHP

require dirname(__FILE__) . "/../vendor/autoload.php";
require dirname(__FILE__) . "/../Psr4AutoloaderClass.php";

$LRConfig = new LearningRegistry\LearningRegistryConfig(
    array(
                                                             "url" => "sandbox.learningregistry.org", //ul
                                                             "username" => "info@pgogywebstuff.com", //username
                                                             "https" => 1, //whether the use https
                                                             "signing" => 1, //sign or not sign
                                                             "password" => "", // passowrd
                                                             "oauthSignature" => "", // oauth signature
                                                             "auth" => "oauth", // use oauth or basic
                                                             "keyPath" => "c:/users/Pat/AppData/Roaming/gnupg/pubring.gpg", // path to key file
                                                             "publicKeyPath" => "http://www.pgogywebstuff.com/public_key.txt" // url for public key
                                                           )
);

// Create a new service (publish means we want to publish)

$LR = new LearningRegistry\LearningRegistryServices\LearningRegistryUpdate($LRConfig);
$LRDocument = new LearningRegistry\LearningRegistryDocuments\LearningRegistryDocument(array("sandbox.learningregistry.org", "25f43f6f8c764be9a92e216e33f8f16c"));
$LRDocument->populateDocument($LR);
//Change the keys
$LR->setResFields(array("keys" => array("good","great")));
$LR->setResFields(array("replaces" => "04bf0cbb95f644078f16dc4b99f4e78a"));
$LR->setResFields(
    array(
        'resource_locator' => "www.wibble.com",
        'resource_data_type' => 'metadata',
        'active' => true,
        'submitter_timestamp' => "",
        'submitter_TTL' => "",
        'resource_TTL' => "",
        'payload_schema_locator' => "",
        'payload_schema_format' => "",
        'doc_type' => 'resource_data',
        'doc_version' => '0.49.0',
        'payload_placement' => 'inline',
        'payload_schema' => array('DC 1.1'),
        'keys' => array("hello")
      )
);
    
    $LR->setSigFields(
        array(
        'signature'  => "",
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
            'resource_data' => htmlspecialchars_decode("I am some data"),
            'replaces' => array("25f43f6f8c764be9a92e216e33f8f16c"),
        )
    );
        
    // Turn the arrays above into a document
    $LR->createDocument();
    $LR->signDocument();
    
    // Verify the document is ok (optional)
    if ($LR->verifyUpdatedDocument()) {
        // make the document into LR format and ready
        $LR->finaliseDocument();
      
        // send the document
      
        $LR->UpdateService();
        echo "the response code is " . $LR->getStatusCode() . "<br />";
        echo "the OK is " . $LR->getOK() . "<br />";
        if ($LR->getOK()!="1") {
            echo "the Error is " . $LR->getError() . "<br />";
        }
    }

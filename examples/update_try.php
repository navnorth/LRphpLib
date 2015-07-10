<?PHP

require dirname(__FILE__) . "/../vendor/autoload.php";
require dirname(__FILE__) . "/../Psr4AutoloaderClass.php";

$LRConfig = new LearningRegistry\LearningRegistryConfig(
    array(
                                                             "url" => "sandbox.learningregistry.org", //ul
                                                             "username" => "info@pgogywebstuff.com", //username
                                                             "https" => 1, //whether the use https
                                                             "signing" => 1, //sign or not sign
                                                             "password" => "Fearher0!", // passowrd
                                                             "oauthSignature" => "", // oauth signature
                                                             "auth" => "basic", // use oauth or basic
                                                             "keyPath" => "c:/users/Pat/AppData/Roaming/gnupg/secring.gpg", // path to key file
                                                             "publicKeyPath" => "http://www.pgogywebstuff.com/public_key.txt" // url for public key
                                                           )
);

// Create a new service (publish means we want to publish)

$LR = new LearningRegistry\LearningRegistryServices\LearningRegistryUpdate($LRConfig);
$LRDocument = new LearningRegistry\LearningRegistryDocuments\LearningRegistryDCMetadata($LR);
$LRDocument->create();

$LRDocument->setIdFields(
    array(
    'curator' => "info@pgogywebstuff.com",
    'owner' => "info@pgogywebstuff.com",
    'signer' => "info@pgogywebstuff.com",
    'submitter_type' => "user",
    'submitter' => "info@pgogywebstuff.com"
    )
);

$LRDocument->setSigFields(
    array(
    'signature'  => "", // mostly set later if signing needed - here now for reference
    'key_server'  => "",
    'key_location'  => "",
    'key_owner'  => "",
    'signing_method'  => "",
    )
);
    
$LRDocument->setResFields(
    array(
    'resource_locator' => "www.wibble.com", //url goes here
    'keys' => array(), // add keys here
    'resource_data' => htmlspecialchars_decode("I am some data, and I am some moresdsdsdsdsd"), // setting the resource data
    )
);

$LR->setResFields(
    array(
            'resource_data' => htmlspecialchars_decode("-"),
            'replaces' => array("617518ab513d41b2b8b2bb16f98df8a7"),
            )
);
      
    
// Turn the arrays above into a document
$LR->createDocument();
$LR->signDocument();
    
// Verify the document is ok (optional)
if ($LR->verifyDocument()) {
    // make the document into LR format and ready
    $LR->finaliseDocument();
      
    // send the document
      
    echo "<br />";
    echo "<br />";
    echo "<br />";
    echo "<br />";
      
    $LR->UpdateService();
    echo "the response code is " . $LR->getStatusCode() . "<br />";
    echo "the OK is " . $LR->getOK() . "<br />";
    if ($LR->getOK()!="1") {
        echo "the Error is " . $LR->getError() . "<br />";
    } else {
        echo "the doc ID is " . $LR->getDocID() . "<br />";
    }
}

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
                                                             "auth" => "basic", // use oauth or basic
															 "fingerprint" => "",
                                                             "keyPath" => "c:/users/Pat/AppData/Roaming/gnupg/pubring.gpg", // path to key file
                                                             "publicKeyPath" => "http://www.pgogywebstuff.com/public_key.txt" // url for public key
                                                           )
);

// Create a new service (publish means we want to publish)

$LR = new LearningRegistry\LearningRegistryServices\LearningRegistryUpdateRemove($LRConfig);
$LRDocument = new LearningRegistry\LearningRegistryDocuments\LearningRegistryReplaceDocument(array("sandbox.learningregistry.org", "61c31414c7414afc98ecddcb48a0b4d4"));
$LRDocument->emptyDocument($LR);
$LRDocument->newResourceData($LR, htmlspecialchars_decode("I am some data"));

// Turn the arrays above into a document
    $LR->createDocument();
    
// Verify the document is ok (optional)
if ($LR->verifyUpdatedDocument()) {
    // make the document into LR format and ready
    $LR->finaliseDocument();
      
    // send the document
      
    $LR->updateRemoveService();
    echo "the response code is " . $LR->getStatusCode() . "<br />";
    echo "the OK is " . $LR->getOK() . "<br />";
    if ($LR->getOK()!="1") {
        echo "the Error is " . $LR->getError() . "<br />";
    } else {
        echo "New ID is " . $LR->getNewID();
    }
}

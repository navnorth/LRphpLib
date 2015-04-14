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

$LR = new LearningRegistry\LearningRegistryServices\LearningRegistryPublish($LRConfig);
$LRDocument = new LearningRegistry\LearningRegistryDocuments\LearningRegistryDocument(array("sandbox.learningregistry.org", "04bf0cbb95f644078f16dc4b99f4e78a"));
$LRDocument->populateDocument($LR);
//Change the keys
$LR->setResFields(array("keys" => array("good","great")));

// Turn the arrays above into a document
$LR->createDocument();
$LR->signDocument();

// Verify the document is ok (optional)
if ($LR->verifyDocument()) {
  // make the document into LR format and ready
    $LR->finaliseDocument();

  // send the document

    $LR->PublishService();
    echo "the response code is " . $LR->getStatusCode() . "<br />";
    echo "the OK is " . $LR->getOK() . "<br />";
    if ($LR->getOK()!="1") {
        echo "the Error is " . $LR->getError() . "<br />";
    } else {
        echo "the doc ID is " . $LR->getDocID() . "<br />";
    }
}

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
                                                             "passphrase" => "", // passowrd
                                                             "oauthSignature" => "", // oauth signature
                                                             "auth" => "basic", // use oauth or basic
                                                             "keyPath" => "", // path to key file
                                                             "publicKeyPath" => "" // url for public key
                                                           )
);

$LR = new LearningRegistry\LearningRegistryServices\LearningRegistryUpdate($LRConfig);
if ($LR->checkNode()) {
    if ($LR->checkNodeActive()) {
        $LR->setIdFields(
            array(
            'curator' => "info@pgogywebstuff.com",
            'owner' => "info@pgogywebstuff.com",
            'signer' => "info@pgogywebstuff.com",
            'submitter_type' => "user",
            'submitter' => "info@pgogywebstuff.com"
            )
        );
    
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
            'keys' => array()
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
            'resource_data' => htmlspecialchars_decode("I am some data, and I am some moresdsdsdsdsd"),
            'replaces' => array("74e40160c45847e494e93813c01e7ff1"),
            )
        );
    
        $LR->createDocument();
        $LR->signDocument();
        if ($LR->verifyUpdatedDocument()) {
            echo "here";
            $LR->finaliseDocument();
            $LR->UpdateService();
            echo "New ID is " . $LR->getResponse();
        }
    
    } else {
        print_r($LR->getResponse());
    }
} else {
    print_r($LR->getResponse());
}

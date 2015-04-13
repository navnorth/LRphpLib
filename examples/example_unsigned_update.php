<?PHP

require dirname(__FILE__) . "/../vendor/autoload.php";
require dirname(__FILE__) . "/../Psr4AutoloaderClass.php";

$LRConfig = new LearningRegistry\LearningRegistryConfig(
    array(
                                                             "url" => "sandbox.learningregistry.org",
                                                             "username" => "info@pgogywebstuff.com",
                                                             "https" => 1,
                                                             "signing" => 0,
                                                             "password" => "",
                                                             "oauthSignature" => "",
                                                             "auth" => "basic",
                                                             "keyPath" => "c:/users/Pat/AppData/Roaming/gnupg/pubring.gpg",
                                                             "publicKeyPath" => "http://www.pgogywebstuff.com/public_key.txt"
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
            'resource_data' => htmlspecialchars_decode("I am some new data"),
            'replaces' => array("61c31414c7414afc98ecddcb48a0b4d4"),
            )
        );
      
        echo "<pre>";
        print_r($LR);
        die();
    
        $LR->createDocument();
        if ($LR->verifyUpdatedDocument()) {
            $LR->finaliseDocument();
            $LR->UpdateService();
            echo "New ID is " . $LR->getNewID();
        }
    
    } else {
        print_r($LR->getResponse());
    }
} else {
    print_r($LR->getResponse());
}

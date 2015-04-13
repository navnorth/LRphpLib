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
                                                             "auth" => "oauth",
                                                             "keyPath" => "c:/users/Pat/AppData/Roaming/gnupg/pubring.gpg",
                                                             "publicKeyPath" => "http://www.pgogywebstuff.com/public_key.txt"
                                                           )
);

$LR = new LearningRegistry\LearningRegistryServices\LearningRegistryServices($LRConfig);
if ($LR->checkNode()) {
    if ($LR->checkNodeActive()) {
        $LR->servicesService();
        $LR->listServices();
    
    }
} else {
    print_r($LR->getResponse());
}

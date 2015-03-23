<?PHP

require dirname(__FILE__) . "/vendor/autoload.php";
require dirname(__FILE__) . "/Psr4AutoloaderClass.php";

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

$LR = new LearningRegistry\LearningRegistryServices\LearningRegistryObtain($LRConfig);
if($LR->checkNode()){
  if($LR->checkNodeActive()){
    
    $LR->ObtainService( 
	                    array(
	                      "request_id" => "cfa-www.harvard.edu/seuforum/download/CosmicSurvey2003.pdf",
						  "by_resource_ID" => "true",
	                    )
	);
	$LR->showDocuments();
	
  }
}else{
  print_r($LR->getResponse());
}
<?PHP

require dirname(__FILE__) . "/../vendor/autoload.php";
require dirname(__FILE__) . "/../Psr4AutoloaderClass.php";

$LRConfig = new LearningRegistry\LearningRegistryConfig('./test_config.txt');

// Create a new service (publish means we want to publish)

$LR = new LearningRegistry\LearningRegistryServices\LearningRegistryPublish($LRConfig);

// Check the node exists (optional)

//if($LR->checkNode()){

// Check the node is active (optional)

  //if($LR->checkNodeActive()){

    // Set the id fields - can be done one parameter at a time

    // Identity fields MUST match original or the Delete/Replace will fail.
    $LR->setIdFields(
        array(
        'owner' => "Joe Hobson",
        'submitter_type' => "user",
        'submitter' => "barry white <joe@navigationnorth.com>"
        )
    );

    // Set the resource fields - can be done one parameter at a time

    $LR->setResFields(
        array(
        'replaces' => array('622e42a22dc34f19adef825c55628495'),
        //'resource_locator' => "", //url goes here
        'resource_data_type' => 'metadata',
        'active' => true,
        //'submitter_timestamp' => "",
        //'submitter_TTL' => "",
        //'resource_TTL' => "",
        //'payload_schema_locator' => "",
        //'payload_schema_format' => "",

        'doc_type' => 'resource_data',
        'doc_version' => '0.49.0',
        'payload_placement' => 'none',
        'payload_schema' => array('DC 1.1'),
        'resource_data' => '',
        //'keys' => array() // add keys here
        )
    );

    $LR->setTosFields(
        array(
        //'tos_submission_attribution' => "",
        'submission_TOS' => "http://learningregistry.org/tos",
        )
    );

    // Turn the arrays above into a document
    $LR->createDocument();

    // Verify the document is ok (optional)

    if ($LR->verifyDocument()) {
        // make the document into LR format and ready

        $LR->finaliseDocument();

        // send the document

        $LR->PublishService();
        print_r($LR->getResponse());
    }

    //  }

    //}

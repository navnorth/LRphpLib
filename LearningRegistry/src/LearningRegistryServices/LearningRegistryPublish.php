<?PHP

  namespace LearningRegistry\LearningRegistryServices;
  
  class LearningRegistryPublish extends LearningRegistryDefault{
  
    protected $document;
    protected $idFields;
    protected $resFields;
    protected $sigFields;
    protected $tosFields;
    
    function getDocData(){
      return $this->data;
    }
    
    function getDocID(){  
      if(is_object(json_decode($this->data->response))){
        $data = json_decode($this->data->response);
        return $data->document_results[0]->doc_ID;
      }
    }
    
    function setIdFields($idData){
      foreach($idData as $key => $value){
        $this->idFields[$key] = $value;
      }
    }
    
    function setResFields($resData){
      foreach($resData as $key => $value){
        $this->resFields[$key] = $value;
      }
    }
    
    function setSigFields($sigData){
      foreach($sigData as $key => $value){
        $this->sigFields[$key] = $value;
      }
    }
    
    function setTosFields($tosData){
      foreach($tosData as $key => $value){
        $this->tosFields[$key] = $value;
      }
    }
    
    function createDocument(){
      
      $identity = new \StdClass();
      $digital_signature = new \StdClass();
      $tos = new \StdClass();
      $resourceData = new \StdClass();
      
      if(count($this->idFields)!=0){
        foreach ($this->idFields as $field => $value) {
          if(is_array($value)){
            $identity->$field = $this->idFields[$field];
          }else{
            if(trim($value)!=""){
              $identity->$field = $this->idFields[$field];  
            }
          }
        }
      }
      $resourceData->identity = $identity;
      
      if($this->getSigning()){
        foreach ($this->sigFields as $field => $value) {
          if(is_array($value)){
            $digital_signature->$field = $this->sigFields[$field];
          }else{
            if(trim($value)!=""){
              $digital_signature->$field = $this->sigFields[$field];  
            }
          }
        }
        $resourceData->digital_signature = $digital_signature;
      }
      
      foreach ($this->tosFields as $field => $value) {
        if(is_array($value)){
          $tos->$field = $this->tosFields[$field];
        }else{
          if(trim($value)!=""){
            $tos->$field = $this->tosFields[$field];
          }
        }
      }
      $resourceData->TOS = $tos;
      
      if(count($this->resFields)!=0){
        foreach ($this->resFields as $field => $value) {
          if(is_array($value)){
            $resourceData->$field = $this->resFields[$field];
          }else{
            if(trim($value)!=""){
              $resourceData->$field = $this->resFields[$field];
            }
          }
        }
      }
      
      $this->resourceData = $resourceData;
      
    }
    
    function verifyDocument(){
      
      if(!isset($this->resourceData->identity->submitter)){
        trigger_error("submitter not set");
        return false;
      }
      
      if(!isset($this->resourceData->identity->submitter_type)){
        trigger_error("submitter type not set");
        return false;
      }
      
      if(!isset($this->resourceData->TOS->submission_TOS)){
        trigger_error("submission TOS not set");
        return false;
      }
      
      if(!isset($this->resourceData->doc_type)){
        trigger_error("doc type not set");
        return false;
      }
      
      if(!isset($this->resourceData->resource_data_type)){
        trigger_error("resource data type not set");
        return false;
      }
      
      if(!isset($this->resourceData->active)){
        trigger_error("active not set");
        return false;
      }
      
      if(!isset($this->resourceData->doc_version)){
        trigger_error("doc version not set");
        return false;
      }
      
      
      if(isset($this->resourceData->payload_placement)){
        if($this->resourceData->payload_placement == "inline"){
          if(!isset($this->resourceData->resource_data)){
            trigger_error("resource data not set");
            return false;
          }
        }
      }
      
      if(!isset($this->resourceData->payload_schema)){
        trigger_error("payload schema not set");
        return false;
      }
      
      return true;
      
    }
    
    function signDocument(){
    
      $document = new \StdClass();
    
      foreach($this->resourceData as $term => $value){
        if($value == true){
          $value == "true";
        }
        if($value == false){
          $value == "false";
        }
        if($value == null){
          $value == "null";
        }
        if($term != "digital_signature"){
          $document->{$term} = $value;
        }
      }
      
      $jsonDocument = json_encode($document);
      $bencoder = new \LearningRegistry\Bencode\LearningRegistryBencodeEncoder($jsonDocument);
      $bencodedDocument = $bencoder->encode($jsonDocument);
      $hashedDocument = hash('SHA256', (string) $bencodedDocument);
      
      $wkey = \OpenPGP\Message::parse(file_get_contents("c:/users/Pat/AppData/Roaming/gnupg/pubring.gpg"));
      $RSA = new \OpenPGP\Crypt\RSA($wkey);
      
      $wkey->packets[0]->key['d'] = $wkey->packets[0]->key['e'];
      $wkey->packets[0]->key['p'] = $wkey->packets[0]->key['e'];
      $wkey->packets[0]->key['q'] = $wkey->packets[0]->key['e'];
      $wkey->packets[0]->key['u'] = $wkey->packets[0]->key['e'];
      
      $m = $RSA->sign($hashedDocument);
      
      $signedDocument = $m->to_bytes();
      
      $this->setSigFields(
        array(
          'signature'  => $signedDocument,
          'key_location'  => array("www.google.com"),
          'signing_method'  => "LR-PGP.1.0",
        )
      );
      
      $this->document = $this->createDocument();
      
    }
    
    function verifySignedDocument(){
    
      if($this->verifyDocument()){
    
        if(!isset($this->resourceData->digital_signature->signature)){
          trigger_error("signature not set");
          return false;
        }
        
        if(!isset($this->resourceData->digital_signature->key_location)){
          trigger_error("key location not set");
          return false;
        }
    
        if(!isset($this->resourceData->digital_signature->signing_method)){
          trigger_error("signing method not set");
          return false;
        }
    
    
      }
      return true;
    
    }
    
    function finaliseDocument(){
    
      $submission = new \StdClass();      
      $submission->documents[] = $this->resourceData;
      $data_to_send = json_encode($submission);      
      $this->document = $data_to_send;
      
    }
    
    function publishService(){
      if(!isset($this->document)){
        $this->document = $this->createDocument();
      }
      echo "here i am";
      if($this->document){
        echo "here";
        if($this->getAuthorization() == "basic"){
          if($this->getPassword() == false || $this->getUsername() == false){
            trigger_error("Username and Password not set");
          }
        } else if($this->getAuthorization() == "oauth"){
          if($this->getUsername() == false || $this->getOAuthSignature() == false){
            trigger_error("Username and OAuth not set");
          }
        }
        $this->service($this->getNodeUrl(), "publish", $this->getAuthorization(), $this->document, "POST");
      }
    }
    
  }
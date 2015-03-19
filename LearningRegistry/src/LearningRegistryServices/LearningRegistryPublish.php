<?PHP

	namespace LearningRegistry\LearningRegistryServices;

	class LearningRegistryPublish extends LearningRegistryDefault{
	
		protected $document;
		protected $idFields;
		protected $resFields;
		protected $sigFields;
		protected $tosFields;
		
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
			$resource_data = new \StdClass();
			
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
			$resource_data->identity = $identity;
			
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
				$resource_data->digital_signature = $digital_signature;
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
			$resource_data->TOS = $tos;
			
			if(count($this->resFields)!=0){
				foreach ($this->resFields as $field => $value) {
					if(is_array($value)){
						$resource_data->$field = $this->resFields[$field];
					}else{
						if(trim($value)!=""){
							$resource_data->$field = $this->resFields[$field];
						}
					}
				}
			}
			
			$this->resource_data = $resource_data;
			
		}
		
		function verifyDocument(){
			
			if(!isset($this->resource_data->identity->submitter)){
				trigger_error("submitter not set");
				return false;
			}
			
			if(!isset($this->resource_data->identity->submitter_type)){
				trigger_error("submitter type not set");
				return false;
			}
			
			if(!isset($this->resource_data->TOS->submission_TOS)){
				trigger_error("submission TOS not set");
				return false;
			}
			
			if(!isset($this->resource_data->doc_type)){
				trigger_error("doc type not set");
				return false;
			}
			
			if(!isset($this->resource_data->resource_data_type)){
				trigger_error("resource data type not set");
				return false;
			}
			
			if(!isset($this->resource_data->active)){
				trigger_error("active not set");
				return false;
			}
			
			if(!isset($this->resource_data->doc_version)){
				trigger_error("doc version not set");
				return false;
			}
			
			if(!isset($this->resource_data->resource_data)){
				trigger_error("resource data not set");
				return false;
			}
			
			if(!isset($this->resource_data->payload_schema)){
				trigger_error("payload schema not set");
				return false;
			}
			
			return true;
			
		}
		
		function formatDocument(){
		
			$submission = new \StdClass();			
			$submission->documents[] = $this->resource_data;
			
			//$bencode = new \Rych\Bencode();
			//$encoded = $bencode->encode($submission);
			
			$data_to_send = json_encode($submission);			
			$this->document = $data_to_send;
			
		}
		
		function publishService(){
			if(!isset($this->document)){
				$this->document = $this->createDocument();
			}
			if($this->document){
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
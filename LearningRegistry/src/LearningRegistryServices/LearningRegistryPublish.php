<?PHP

namespace LearningRegistry\LearningRegistryServices;

class LearningRegistryPublish extends LearningRegistryDefault
{

    protected $document;
    protected $idFields;
    protected $resFields;
    protected $sigFields;
    protected $tosFields;

    public function getDocData()
    {
        return $this->data;
    }

    public function getDocID()
    {
        if (is_object(json_decode($this->data->response))) {
            $data = json_decode($this->data->response);
            return $data->document_results[0]->doc_ID;
        }
    }

    public function unsetResFields($resData)
    {
        foreach ($resData as $key) {
            unset($this->resFields[$key]);
        }
    }

    public function setIdFields($idData)
    {
        foreach ($idData as $key => $value) {
            $this->idFields[$key] = $value;
        }
    }

    public function setResFields($resData)
    {
        foreach ($resData as $key => $value) {
            $this->resFields[$key] = $value;
        }
    }

    public function setSigFields($sigData)
    {
        foreach ($sigData as $key => $value) {
            $this->sigFields[$key] = $value;
        }
    }

    public function setTosFields($tosData)
    {
        foreach ($tosData as $key => $value) {
            $this->tosFields[$key] = $value;
        }
    }

    public function createDocument()
    {

        $identity = array();
        $digital_signature = new \StdClass();
        $tos = array();
        $resourceData = new \StdClass();

        if (count($this->idFields)!=0) {
            foreach ($this->idFields as $field => $value) {
                if (is_array($value)) {
                    $identity[$field] = $this->idFields[$field];
                } else {
                    if (trim($value)!="") {
                        $identity[$field] = $this->idFields[$field];
                    }
                }
            }
        }
        $resourceData->identity = $identity;

        if ($this->getSigning()) {
            if (count($this->sigFields)!=0) {
                foreach ($this->sigFields as $field => $value) {
                    if (is_array($value)) {
                        $digital_signature->$field = $this->sigFields[$field];
                    } else {
                        if (trim($value)!="") {
                            $digital_signature->$field = $this->sigFields[$field];
                        }
                    }
                }
                $resourceData->digital_signature = $digital_signature;
            }
        }

        if (count($this->tosFields)!=0) {
            foreach ($this->tosFields as $field => $value) {
                if (is_array($value)) {
                    $tos[$field] = $this->tosFields[$field];
                } else {
                    if (trim($value)!="") {
                        $tos[$field] = $this->tosFields[$field];
                    }
                }
            }
            $resourceData->TOS = $tos;
        }

        if (count($this->resFields)!=0) {
            foreach ($this->resFields as $field => $value) {
                if (is_array($value)) {
                    $resourceData->$field = $this->resFields[$field];
                } else {
                    if (trim($value)!="") {
                        $resourceData->$field = $this->resFields[$field];
                    }
                }
            }
        }

        $this->resourceData = $resourceData;

    }

    public function verifyDocument($tos = false)
    {

        $this->errors = array();

        if (!isset($this->resourceData->identity['submitter'])) {
            array_push($this->errors, "submitter not set");
            trigger_error("submitter not set");
            return false;
        }

        if (!isset($this->resourceData->identity['submitter_type'])) {
            array_push($this->errors, "submitter type not set");
            trigger_error("submitter type not set");
            return false;
        }

        if (!isset($this->resourceData->TOS['submission_TOS'])) {
            array_push($this->errors, "submission TOS not set");
            trigger_error("submission TOS not set");
            return false;
        }

        if (!isset($this->resourceData->doc_type)) {
            array_push($this->errors, "doc type not set");
            trigger_error("doc type not set");
            return false;
        }

        if (!isset($this->resourceData->resource_data_type)) {
            array_push($this->errors, "resource data type not set");
            trigger_error("resource data type not set");
            return false;
        }

        if (!isset($this->resourceData->active)) {
            array_push($this->errors, "active not set");
            trigger_error("active not set");
            return false;
        }

        if (!isset($this->resourceData->doc_version)) {
            array_push($this->errors, "doc version not set");
            trigger_error("doc version not set");
            return false;
        }

        if (isset($this->resourceData->payload_placement)) {
            if ($this->resourceData->payload_placement == "inline") {
                if (!isset($this->resourceData->resource_data)) {
                    array_push($this->errors, "resource data not set");
                    trigger_error("resource data not set");
                    return false;
                }
            }
        }

        if ($tos) {
            if (!isset($this->TOS['submission_TOS'])) {
                array_push($this->errors, "doc version not set");
                trigger_error("doc version not set");
                return false;
            }
        }

        if (!isset($this->resourceData->payload_schema)) {
            array_push($this->errors, "payload schema not set");
            trigger_error("payload schema not set");
            return false;
        }

        return true;

    }

    public function normalizeData($data)
    {
        if (is_null($data)) {
            return "null";
        } elseif (is_numeric($data)) {
            return strval($data);
        } elseif (is_bool($data)) {
            return $data ? "true" : "false";
        } elseif (is_array($data)) {
            foreach ($data as $subKey => $subValue) {
                $data[$subKey] = $this->normalizeData($subValue);
            }
        }
        return $data;
    }

    public function signDocument()
    {
        $document = new \StdClass();

        foreach ($this->resourceData as $term => $value) {
            $document->{$term} = $this->normalizeData($value);
        }

        unset($document->digital_signature);
        unset($document->_id);
        unset($document->_rev);
        unset($document->doc_id);
        unset($document->publishing_node);
        unset($document->update_timestamp);
        unset($document->node_timestamp);
        unset($document->create_timestamp);

        //$jsonDocument = json_encode($document);
        
        $bencoder = new \LearningRegistry\Bencode\LearningRegistryBencodeEncoderTrial();
        $document = (array) $document;
        $bencodedDocument = utf8_encode($bencoder->encode($document));
        $hashedDocument = hash('SHA256', $bencodedDocument);

        global $loader;
        spl_autoload_unregister(array($loader, 'loadClass'));

        require_once dirname(__FILE__).'/../OpenPGP/openpgp.php';
        require_once dirname(__FILE__).'/../OpenPGP/openpgp_crypt_rsa.php';
        require_once dirname(__FILE__).'/../OpenPGP/openpgp_crypt_symmetric.php';

        $keyASCII = file_get_contents($this->getKeyPath());

        $keyEncrypted = \OpenPGP_Message::parse(\OpenPGP::unarmor($keyASCII, 'PGP PRIVATE KEY BLOCK'));

        foreach ($keyEncrypted as $p) {
            if (!($p instanceof \OpenPGP_SecretKeyPacket)) {
                continue;
            }
            $key = \OpenPGP_Crypt_Symmetric::decryptSecretKey($this->getPassPhrase(), $p);
        }

        $data = new \OpenPGP_LiteralDataPacket($hashedDocument, array('format' => 'u'));
        $sign = new \OpenPGP_Crypt_RSA($key);
        $m = $sign->sign($data);
        $packets = $m->signatures()[0];
        $message = "-----BEGIN PGP SIGNED MESSAGE-----\nHash: SHA256\n\n";
        $message .= $packets[0]->data ."\n";
        $message .= "-----BEGIN PGP SIGNATURE-----\n\n";
        $signed_data = str_replace("-----BEGIN -----", "", str_replace("-----END -----", "", \OpenPGP::enarmor($packets[1][0]->to_bytes(), "")));
        $signature = str_split(trim($signed_data), 65);
        foreach ($signature as $line) {
            $message .= $line . "\n";
        }
        $message .= "-----END PGP SIGNATURE-----\n";

        $this->setSigFields(
            array(
            'signature'  => $message,
            'key_owner'  => $this->getKeyOwner(),
            'key_location'  => array($this->getPublicKeyPath()),
            'signing_method'  => "LR-PGP.1.0",
            )
        );

        spl_autoload_register(array($loader, 'loadClass'));

        $this->document = $this->createDocument();

    }

    public function verifySignedDocument()
    {

        if ($this->verifyDocument()) {
            if (!isset($this->resourceData->digital_signature->signature)) {
                trigger_error("signature not set");
                return false;
            }

            if (!isset($this->resourceData->digital_signature->key_location)) {
                trigger_error("key location not set");
                return false;
            }

            if (!isset($this->resourceData->digital_signature->signing_method)) {
                trigger_error("signing method not set");
                return false;
            }


        }
        return true;

    }

    public function finaliseDocument()
    {

        $submission = new \StdClass();
        $submission->documents[] = $this->resourceData;
        $data_to_send = json_encode($submission);
        $this->document = $data_to_send;

    }

    public function publishService()
    {

        if (!isset($this->document)) {
            $this->document = $this->createDocument();
        }

        if ($this->document) {
            if ($this->getAuthorization() == "basic") {
                if ($this->getPassword() == false || $this->getUsername() == false) {
                    trigger_error("Username and Password not set");
                }
            } elseif ($this->getAuthorization() == "oauth") {
                if ($this->getUsername() == false || $this->getOAuthSignature() == false) {
                    trigger_error("Username and OAuth not set");
                }
            }
            $this->service($this->getNodeUrl(), "publish", $this->getAuthorization(), $this->document, "POST");
        }

    }
}

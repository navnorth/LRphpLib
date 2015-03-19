<?php

namespace LearningRegistry\Http;

class LearningRegistryUri extends \OAuth\Common\Http\Uri\Uri
{
   
    private $host = "";
    private $path = "";
	private $query = "";

    /**
     * @return string
     */
    public function getHost(){
		return $this->host;
	}

    /**
     * @param string $host
     */
    public function setHost($host){
		$this->host = $host;
	}

    /**
     * @return string
     */
    public function getPath(){
		return $this->path;
	}

    /**
     * @param string $path
     */
    public function setPath($path){
		$this->path .= $path;
	}

    /**
     * @return string
     */
    public function getQuery(){
		return $this->query;
	}

    /**
     * @param string $query
     */
    public function setQuery($query){
		$this->query .= $query;
	}

    /**
     * Adds a param to the query string.
     *
     * @param string $var
     * @param string $val
     */
    public function addToQuery($var, $val){
		$this->setQuery($var . "=" . $val);
	}


    /**
     * Should return the URI string, masking protected user info data according to rfc3986-3.2.1
     *
     * @return string the URI string with user protected info masked
     */
    public function __toString(){
		$query = $this->getQuery();
		if($query == ""){
			return $this->host . $this->getPath();
		}else{
			return $this->host . $this->getPath() . "?" . $query;
		}
	}

}

<?PHP
namespace LearningRegistry\OAuth;

use \OAuth\Common\Consumer\CredentialsInterface;
use \OAuth\Common\Exception\Exception;
use \OAuth\Common\Service\AbstractService as BaseAbstractService;
use \OAuth\Common\Storage\TokenStorageInterface;
use \OAuth\Common\Http\Exception\TokenResponseException;
use \OAuth\Common\Http\Client\ClientInterface;
use \OAuth\Common\Http\Uri\UriInterface;
use \OAuth\OAuth2\Service\Exception\InvalidAuthorizationStateException;
use \OAuth\OAuth2\Service\Exception\InvalidScopeException;
use \OAuth\OAuth2\Service\Exception\MissingRefreshTokenException;
use \OAuth\Common\Token\TokenInterface;
use \OAuth\Common\Token\Exception\ExpiredTokenException;

class LearningRegistryOAuth extends BaseAbstractService implements \OAuth\OAuth2\Service\ServiceInterface
{
    /**
 * @const OAUTH_VERSION
*/
    const OAUTH_VERSION = 2;
    /**
 * @var array
*/
    protected $scopes;
    /**
 * @var UriInterface|null
*/
    protected $baseApiUri;
    /**
 * @var bool
*/
    protected $stateParameterInAuthUrl;
    
    /**
 * @var string
*/
    protected $apiVersion;
    /**
     * @param CredentialsInterface  $credentials
     * @param ClientInterface       $httpClient
     * @param TokenStorageInterface $storage
     * @param array                 $scopes
     * @param UriInterface|null     $baseApiUri
     * @param bool                  $stateParameterInAutUrl
     * @param string                $apiVersion
     *
     * @throws InvalidScopeException
     */
    public function __construct(
        CredentialsInterface $credentials,
        ClientInterface $httpClient,
        TokenStorageInterface $storage,
        $scopes = array(),
        UriInterface $baseApiUri = null,
        $stateParameterInAutUrl = false,
        $apiVersion = ""
    ) {
        parent::__construct($credentials, $httpClient, $storage);
        $this->scopes = $scopes;
        $this->baseApiUri = $baseApiUri;
        $this->apiVersion = $apiVersion;
    }
    /**
     * {@inheritdoc}
     */
    public function getAuthorizationUri(array $additionalParameters = array())
    {
    }
    /**
     * {@inheritdoc}
     */
    public function requestAccessToken($code, $state = null)
    {
    }
    /**
     * Sends an authenticated API request to the path provided.
     * If the path provided is not an absolute URI, the base API Uri (must be passed into constructor) will be used.
     *
     * @param string|UriInterface $path
     * @param string              $method       HTTP method
     * @param array               $body         Request body if applicable.
     * @param array               $extraHeaders Extra headers if applicable. These will override service-specific
     *                                          any defaults.
     *
     * @return string
     *
     * @throws ExpiredTokenException
     * @throws Exception
     */
    public function request($path, $method = 'GET', $body = null, array $extraHeaders = array())
    {
        return $this->httpClient->retrieveResponse($path, $body, $extraHeaders, $method);
    }
    /**
     * Accessor to the storage adapter to be able to retrieve tokens
     *
     * @return TokenStorageInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }
    /**
     * Refreshes an OAuth2 access token.
     *
     * @param TokenInterface $token
     *
     * @return TokenInterface $token
     *
     * @throws MissingRefreshTokenException
     */
    public function refreshAccessToken(TokenInterface $token)
    {
    }
    /**
     * Return whether or not the passed scope value is valid.
     *
     * @param string $scope
     *
     * @return bool
     */
    public function isValidScope($scope)
    {
    }
    /**
     * Check if the given service need to generate a unique state token to build the authorization url
     *
     * @return bool
     */
    public function needsStateParameterInAuthUrl()
    {
    }
    /**
     * Validates the authorization state against a given one
     *
     * @param  string $state
     * @throws InvalidAuthorizationStateException
     */
    protected function validateAuthorizationState($state)
    {
    }
    /**
     * Generates a random string to be used as state
     *
     * @return string
     */
    protected function generateAuthorizationState()
    {
    }
    /**
     * Retrieves the authorization state for the current service
     *
     * @return string
     */
    protected function retrieveAuthorizationState()
    {
    }
    /**
     * Stores a given authorization state into the storage
     *
     * @param string $state
     */
    protected function storeAuthorizationState($state)
    {
    }
    /**
     * Return any additional headers always needed for this service implementation's OAuth calls.
     *
     * @return array
     */
    protected function getExtraOAuthHeaders()
    {
    }
    /**
     * Return any additional headers always needed for this service implementation's API calls.
     *
     * @return array
     */
    protected function getExtraApiHeaders()
    {
    }
    /**
     * Parses the access token response and returns a TokenInterface.
     *
     * @abstract
     *
     * @param string $responseBody
     *
     * @return TokenInterface
     *
     * @throws TokenResponseException
     */
    public function getAccessTokenEndpoint()
    {
  
    }
  
    public function getAuthorizationEndpoint()
    {
  
    }
  
    public function parseAccessTokenResponse()
    {
  
    }
    /**
     * Returns a class constant from ServiceInterface defining the authorization method used for the API
     * Header is the sane default.
     *
     * @return int
     */
    protected function getAuthorizationMethod()
    {
    }
    
    /**
     * Returns api version string if is set else retrun empty string
     *
     * @return string
     */
    protected function getApiVersionString()
    {
    }
}

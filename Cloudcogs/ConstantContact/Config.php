<?php
namespace Cloudcogs\ConstantContact;

use Cloudcogs\ConstantContact\Exception\DuplicateScopeException;

class Config
{
    protected $params = [];

    public function __construct(string $client_id, string $client_secret, string $redirect_uri = 'https://localhost', array $scope = [Constants::SCOPE_CONTACT_DATA], string $grant_type = 'authorization_code')
    {
        $this->params[Constants::PARAM_CLIENT_ID] = $client_id;
        $this->params[Constants::PARAM_CLIENT_SECRET] = $client_secret;
        $this->params[Constants::PARAM_REDIRECT_URI] = urlencode($redirect_uri);
        $this->params[Constants::PARAM_GRANT_TYPE] = $grant_type;
        $this->params[Constants::PARAM_SCOPE] = $scope;
    }

    public function getAuthCredentials() : string
    {
        return base64_encode($this->getClientId().":".$this->params[Constants::PARAM_CLIENT_SECRET]);
    }

    public function getClientId() : string
    {
        return $this->params[Constants::PARAM_CLIENT_ID];
    }

    public function getRedirectURI() : string
    {
        return $this->params[Constants::PARAM_REDIRECT_URI];
    }

    public function getGrantType() : string
    {
        return $this->params[Constants::PARAM_GRANT_TYPE];
    }

    public function getScope() : array
    {
        return $this->params[Constants::PARAM_SCOPE];
    }

    public function getScopeAsString() : string
    {
        return implode("+", $this->params[Constants::PARAM_SCOPE]);
    }

    /**
     * Add a scope for authorization
	 *
	 * @throws DuplicateScopeException
     */
    public function addScope(string $scope) : \Cloudcogs\ConstantContact\Config
    {
        if (!in_array($scope, $this->params[Constants::PARAM_SCOPE]))
        {
            $this->params[Constants::PARAM_SCOPE][] = $scope;
            return $this;
        }

        throw new DuplicateScopeException($scope);
    }
}
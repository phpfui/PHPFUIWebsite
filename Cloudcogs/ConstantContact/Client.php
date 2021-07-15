<?php

namespace Cloudcogs\ConstantContact;

use Cloudcogs;
use Cloudcogs\ConstantContact\Exception\InvalidAccessTokenResult;
use Cloudcogs\ConstantContact\Exception\AccessTokenNotDefined;
use Cloudcogs\ConstantContact\Exception\CurlSetupException;
use Cloudcogs\ConstantContact\Exception\AccessTokenResponseFileNotFound;
use Cloudcogs\ConstantContact\Api\ContactLists;
use Cloudcogs\ConstantContact\Api\Contacts;

class Client
{
    public const BASEURL_API = "https://api.cc.email/v3";
    private const BASEURL_AUTH = "https://api.cc.email/v3/idfed";
    private const BASEURL_OAUTH2 = "https://idfed.constantcontact.com/as/token.oauth2";

    protected $Config;
    protected $AccessTokenResponse;
    protected $ContactLists;
    protected $Contacts;

    public function __construct(\Cloudcogs\ConstantContact\Config $Config)
    {
        $this->Config = $Config;
    }

    public function getAuthorizationURL() : string
    {
        return self::BASEURL_AUTH . "?client_id=" . $this->Config->getClientId(). "&scope=" . $this->Config->getScopeAsString(). "&response_type=code" . "&redirect_uri=" . $this->Config->getRedirectURI();
    }

    /**
     * @throws AccessTokenNotDefined
     * @throws AccessTokenResponseFileNotFound
     */
    public function getAccessTokenResponseFromFile(string $file = ".access_token") : \Cloudcogs\ConstantContact\AccessTokenResponse
    {
        if (file_exists($file))
        {
            $response = file_get_contents($file);
            $AccessTokenResponse = unserialize($response);

            if(!($AccessTokenResponse instanceof \Cloudcogs\ConstantContact\AccessTokenResponse))
            {
                throw new AccessTokenNotDefined();
            }

            $this->AccessTokenResponse = $AccessTokenResponse;

            return $this->AccessTokenResponse;
        }

        throw new AccessTokenResponseFileNotFound($file);
    }

    /**
     * @throws AccessTokenNotDefined
     */
    public function writeAccessTokenResponseToFile(string $file = ".access_token") : \Cloudcogs\ConstantContact\Client
    {
        if(!($this->AccessTokenResponse instanceof \Cloudcogs\ConstantContact\AccessTokenResponse))
        {
            throw new AccessTokenNotDefined();
        }

        $ac = fopen($file, "w");
        if ($ac)
        {
            fwrite($ac, serialize($this->AccessTokenResponse));
            fclose($ac);
        }

        return $this;
    }

    /**
     * @throws \Cloudcogs\ConstantContact\Exception\InvalidAccessTokenResult
     */
    public function getAccessToken(string $authorization_code = null) : string
    {
        if($this->AccessTokenResponse instanceof \Cloudcogs\ConstantContact\AccessTokenResponse)
        {
            return $this->AccessTokenResponse->getAccessToken();
        }

        $url = self::BASEURL_OAUTH2 . "?code=" . $authorization_code . "&redirect_uri=" . $this->Config->getRedirectURI() . "&grant_type=" . $this->Config->getGrantType() . "&scope=" . $this->Config->getScopeAsString();

        return $this->getOrRefreshAccessToken($url);
    }

    /**
     * @throws AccessTokenNotDefined
     */
    public function getRefreshToken() : string
    {
        if(!($this->AccessTokenResponse instanceof \Cloudcogs\ConstantContact\AccessTokenResponse))
        {
            throw new AccessTokenNotDefined();
        }

        return $this->AccessTokenResponse->getRefreshToken();
    }

    public function refreshAccessToken()
    {
        $url = self::BASEURL_OAUTH2 . "?refresh_token=" . $this->getRefreshToken() . "&grant_type=refresh_token";
        return $this->getOrRefreshAccessToken($url);
    }

    protected function getOrRefreshAccessToken($url) : string
    {
        $ch = curl_init();

        if($ch)
        {
            $authorization = 'Authorization: Basic ' . $this->Config->getAuthCredentials();

            curl_setopt($ch, \CURLOPT_URL, $url);
            curl_setopt($ch, \CURLOPT_HTTPHEADER, array($authorization));
            curl_setopt($ch, \CURLOPT_POST, true);
            curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch);
            curl_close($ch);

            $this->AccessTokenResponse = new AccessTokenResponse($result);
            $this->writeAccessTokenResponseToFile();

            return $this->AccessTokenResponse->getAccessToken();
        }

        throw new CurlSetupException();
    }

    /**
     * @throws DuplicateScopeException
     */
    public function addScope(string $scope) : \Cloudcogs\ConstantContact\Client
    {
        $this->Config->addScope($scope);

        return $this;
    }

    /**
     * Proxy to the ContactLists API
     */
    public function ContactLists() : \Cloudcogs\ConstantContact\Api\ContactLists
    {
        if(!$this->ContactLists)
        {
            $this->ContactLists = new ContactLists($this);
        }

        return $this->ContactLists;
    }

    /**
     * Proxy to the Contacts API
     */
    public function Contacts() : \Cloudcogs\ConstantContact\Api\Contacts
    {
        if (!$this->Contacts)
        {
            $this->Contacts = new Contacts($this);
        }

        return $this->Contacts;
    }
}
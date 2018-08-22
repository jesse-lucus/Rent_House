<?php

//declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AuthService
{

    /**
     * Base URL For API calls
     * @var string
     */
    private $_url;

    /**
     * Username For API calls
     * @var string
     */
    private $_username;

    /**
     * Password For API calls
     * @var string
     */
    private $_password;

    /**
     * System Level Dev|Co API Token
     * @var string
     */
    private $_devco_token;

    /**
     * Guzzle Client for calls
     * @var
     */
    private $_client;


    public function __construct()
    {
        $this->_url = config('allita.api.url');
        $this->_username = config('allita.api.username');
        $this->_password = config('allita.api.password');

        $this->_devco_token = 'bxKmxPmSIGIM5CvfsOQnt9n'; //SystemConfig::get('devco_token');

        $this->_client = new Client([
            'base_uri' => $this->_url,
            'timeout'  => 10.0,
        ]);
    }

    public function rootKeyRoot()
    {
        $endpoint = "/root/key-reset?username={$this->_username}&password={$this->_password}&key{$this->_devco_token}";

        try {
            $response = $this->_client->request('GET', $endpoint);

            if ($response->getStatusCode() === 200) {

                dd($response->getBody());

            }

            throw new \Exception("Unexpected Status Code ({$response->getStatusCode()})");

        } catch (GuzzleException | \Exception $e) {

            dd($e->getMessage());

        }

    }


    public function rootAuthenticate()
    {
        $endpoint = '/api/v1/root/authenticate';
        /*
        - System API Username
        - System API Password
        - System API Key
        */



    }

    public function rootRefreshToken()
    {
        $endpoint = '/api/v1/root/refresh-token';
        /*
        - System API Key
        - System Access Token
        - System Refresh Token
        */




    }


    public function userAuthenticateToken()
    {
        $endpoint = '/api/v1/devco/user/authenticate-token';
        /*
        - System Access Token
        - IP Address
        - User Agent
        - User Token
        */

    }



    private function _parseJsonApiResponse($response)
    {

        


    }




    //
    //
    //
    //
    //




    /**
     * Device Is Authorized
     *
     * @param $user_id
     * @param $device_id
     *
     * @return bool
     */
    static public function deviceIsAuthorized($user_id, $device_id)
    {
        return true;
    }

    /**
     * Attempt Device Authorization
     *
     * @param $device_id
     * @param $verification_code
     *
     * @return bool
     */
    static public function attemptDeviceAuthorization($device_id, $verification_code)
    {
        return true;
    }
}

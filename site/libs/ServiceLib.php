<?php

class ServiceLib
{
    public static function getGoogleAuthService() : Google\Service\Oauth2
    {
        static $googleAuthService = null;

        if ($googleAuthService == null)
        {
            $client = self::getGoogleClient();
            $googleAuthService = new Google\Service\Oauth2($client);
        }

        return $googleAuthService;
    }


    public static function getGoogleClient() : Google\Client
    {
        static $googleClient = null;

        if ($googleClient == null)
        {
            $googleClient = new Google\Client();
            $googleClient->setApplicationName("MySite.com");
            $googleClient->setClientId(GOOGLE_AUTH_CLIENT_ID);
            $googleClient->setClientSecret(GOOGLE_AUTH_SECRET);
            $googleClient->setRedirectUri("http://localhost/google-auth-response-handler");
        }

        return $googleClient;
    }
}
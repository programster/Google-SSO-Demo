<?php

class AuthLib
{
    public static function isLoggedIn() : bool
    {
        return isset($_SESSION['USER_EMAIL']);
    }


    public static function setLoggedIn(string $email, string $firstName, string $lastName, GoogleAccessTokenObject $accessToken) : void
    {
        $_SESSION['USER_EMAIL'] = $email;
        $_SESSION['USER_FIRST_NAME'] = $firstName;
        $_SESSION['USER_LAST_NAME'] = $lastName;
        $_SESSION['GOOGLE_OAUTH_ACCESS_TOKEN'] = $accessToken;
    }


    public static function getUserEmail() : string
    {
        if (self::isLoggedIn() === false)
        {
            throw new \Exception("User is not logged in");
        }

        return $_SESSION['USER_EMAIL'];
    }


    public static function logout() : void
    {
        $google = ServiceLib::getGoogleClient();
        $google->revokeToken();
        session_destroy();
    }
}
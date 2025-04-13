<?php

class HomeController extends AbstractSlimController
{

    public static function registerRoutes(\Slim\App $app) : void
    {
        // home/landing page that one should see if one is logged in.
        $app->get('/', function (Slim\Psr7\Request $request, Slim\Psr7\Response $response, $args) {
            $homeController = new HomeController($request, $response, $args);
            return $homeController->handleGetHomePage();
        })->setName('home');


        // login route for either displaying a "login with google" button
        $app->get('/login', function (Slim\Psr7\Request $request, Slim\Psr7\Response $response, $args) {
            $homeController = new HomeController($request, $response, $args);
            return $homeController->handleGetLoginPage();
        })->setName('login');


        // Route for handling user having clicked on the button to trigger logging in with google.
        $app->get('/login-with-google', function (Slim\Psr7\Request $request, Slim\Psr7\Response $response, $args) {
            $homeController = new HomeController($request, $response, $args);
            return $homeController->handleLoginWithGoogleSubmit();
        })->setName('login-with-google');


        $app->get('/logout', function (Slim\Psr7\Request $request, Slim\Psr7\Response $response, $args) {
            $homeController = new HomeController($request, $response, $args);
            return $homeController->handleLogoutRequest();
        })->setName('logout');


        // route for handling google auth's response.
        $app->get('/google-auth-response-handler', function (Slim\Psr7\Request $request, Slim\Psr7\Response $response, $args) {
            $homeController = new HomeController($request, $response, $args);
            return $homeController->handleGoogleLoginResponse();
        })->setName('google-response-handler');
    }


    private function handleLogoutRequest() : \Psr\Http\Message\ResponseInterface
    {
        if (AuthLib::isLoggedIn())
        {
            AuthLib::logout();
        }

        $body = $this->m_response->getBody();
        $page = new ViewHtmlShell((string)new ViewLogoutPage());
        $body->write((string)$page); // returns number of bytes written
        $newResponse = $this->m_response->withBody($body);
        return $newResponse;
    }


    private function handleLoginWithGoogleSubmit()
    {
        if (AuthLib::isLoggedIn())
        {
            $response = SlimLib::createRedirectResponse("/home");
        }
        else
        {
            $gAuth = ServiceLib::getGoogleClient();
            $scopes = [
                \Google\Service\Oauth2::USERINFO_EMAIL,
                \Google\Service\Oauth2::USERINFO_PROFILE
            ];

            $authUrl = $gAuth->createAuthUrl($scopes);
            $response = SlimLib::createRedirectResponse($authUrl);
        }

        return $response;
    }


    private function handleGetLoginPage() : \Psr\Http\Message\ResponseInterface
    {
        if (AuthLib::isLoggedIn())
        {
            $response = SlimLib::createRedirectResponse("/home");
        }
        else
        {
            $body = $this->m_response->getBody();
            $body->write((string)new ViewLoginPage()); // returns number of bytes written
            $response = $this->m_response->withBody($body);
        }

        return $response;
    }


    private function handleGetHomePage() : \Psr\Http\Message\ResponseInterface
    {
        $body = $this->m_response->getBody();
        $page = new ViewHtmlShell((string)new ViewHomePage(AuthLib::getUserEmail()));
        $body->write((string)$page); // returns number of bytes written
        $newResponse = $this->m_response->withBody($body);
        return $newResponse;
    }


    /**
     * Handler for handling response from google which will hopefully provide a code for retrieving details about the
     * user, if they logged in successfully.
     * @return void
     */
    private function handleGoogleLoginResponse()
    {
        if (isset($_GET['code']))
        {
            // if google provided an ID token, then immediately hand it back to google to get an access token.
            $gClient = ServiceLib::getGoogleClient();
            $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
            $accessTokenObj = new GoogleAccessTokenObject($gClient->getAccessToken());

            $userinfo = ServiceLib::getGoogleAuthService()->userinfo->get();
            $email = $userinfo['email'];
            $firstName = $userinfo['given_name'];
            $lastName = $userinfo['family_name'];

//            $gData['last_name']  = !empty($gProfile['family_name'])?$gProfile['family_name']:'';

            //            $gData['oauth_uid']  = !empty($gProfile['id'])?$gProfile['id']:'';
//            $gData['first_name'] = !empty($gProfile['given_name'])?$gProfile['given_name']:'';
//            $gData['last_name']  = !empty($gProfile['family_name'])?$gProfile['family_name']:'';
//            $gData['email']      = !empty($gProfile['email'])?$gProfile['email']:'';
//            $gData['gender']     = !empty($gProfile['gender'])?$gProfile['gender']:'';
//            $gData['locale']     = !empty($gProfile['locale'])?$gProfile['locale']:'';
//            $gData['picture']    = !empty($gProfile['picture'])?$gProfile['picture']:'';

            AuthLib::setLoggedIn($email, $firstName, $lastName, $accessTokenObj);
            return SlimLib::createRedirectResponse("/");
        }
    }
}
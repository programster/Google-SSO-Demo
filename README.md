Login With Google PHP Demo
==========================

This codebase demonstrates the ability to "login with Google", when building a website in PHP.
This makes use of the Slim4 framework for routing, and the `google/apiclient` PHP package to assist
with the Google OAuth2 flow.

The following article proved immensely helpful when putting this codebase together: 
https://www.coderglass.com/php/login-with-google-in-php.php and would be appropriate to others
who want an example that is more "raw" or stripped down.


## Usage
1. Clone the repository.
2. Register an application with Google to get a google client ID and secret for  your website to
   use for logging in with Google (details further down). 
3. Create a `.env` file from the `.env.example` and give it your Google app credentials.
4. Navigate to the site folder and run `composer install` to install the packages.
5. Navigate to the site/public folder and run `sudo php -S localhost:80` to run the website locally.
6. Navigate to <a href="http://localhost">http://localhost</a> in your browser to see the demo site.

For the above to work, you may need to install PHP 8.4 and composer.


## Getting Google Credentials
In order to be able to use Google to authenticate user logins, you need to register your application
with google to generate a client ID and secret. You can do this by going to the [Google API 
Console](https://console.cloud.google.com/apis/dashboard).

1. Then create a new project, give it a name, and click create. 
2. Then select **Credentials** from the panel on the left in the **APIs & Services** section. 
3. Then click **Configure consent screen**. 
4. Then **Get started**. 
5. Then create Oauth2 client. 
6. Set the type to Web application. 
7. Give the application  name. 
8. Set the authorised redirect URIs. 
9. Copy down the client ID, and secret.








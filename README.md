# RevModern

This repository contains the RevCMS source code. Before running the application you must configure your site settings.

1. Copy `app/management/config.php.example` to `app/management/config.php`.
2. Edit `config.php` and replace the placeholder values with your database credentials and other hotel information.
3. Install PHP dependencies with [Composer](https://getcomposer.org/):

   ```bash
   composer install
   ```
4. Set your reCAPTCHA site key and secret key in `app/management/config.php`.

The CMS relies on Google's [`google/recaptcha`](https://github.com/google/recaptcha) library for spam protection.

After configuration you can point your web server to `index.php` and start the CMS.
The default website template is located in `app/tpl/skins/default/`.

## Running on IIS

1. Install **PHP 8.x** and enable the *PDO* and *OpenSSL* extensions. On Windows
   this is typically done through the [PHP for Windows](https://www.php.net/manual/en/install.windows.php)
   packages.
2. Install **URL Rewrite** and **FastCGI** through the *Web Platform Installer*.
3. Create a new IIS site pointing to the repository directory. Set the site to
   use the installed PHP version via FastCGI.
4. Copy `app/management/config.php.example` to `app/management/config.php` and
   adjust the database credentials, hotel URL and other settings.
5. Run `composer install` from the site directory to fetch dependencies.
6. Add a `web.config` file to the site root with the following rewrite rule:

   ```xml
   <?xml version="1.0" encoding="UTF-8"?>
   <configuration>
     <system.webServer>
       <rewrite>
         <rules>
           <rule name="Rewrite to index.php" stopProcessing="true">
             <match url=".*" />
             <conditions>
               <add input="{REQUEST_FILENAME}" matchType="IsFile" negate="true" />
               <add input="{REQUEST_FILENAME}" matchType="IsDirectory" negate="true" />
             </conditions>
             <action type="Rewrite" url="index.php?url={R:0}" />
           </rule>
         </rules>
       </rewrite>
     </system.webServer>
   </configuration>
   ```

This rule forwards all requests to `index.php`, allowing the CMS router to
serve friendly URLs. You can now browse to your IIS site and complete the hotel
setup.

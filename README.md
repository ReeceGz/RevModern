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

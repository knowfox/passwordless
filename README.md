# Passwordless Login for Laravel

This module implements a Medium/Slack-inspired password-less login for Laravel sites. It is part of the [personal knowledge management system Knowfox](https://knowfox.com).

## Installation

* Require the module into your project by
  ````
  composer require knowfox/passwordless
  ````
* Install the service provider by adding the line
  ````
  Knowfox\Passwordless\ServiceProvider::class,
  ````
  ... in array `providers` in your `config/app.php`.
* Remove the line
  ````
  Auth::routes();
  ````
  ... from your `routes/web.php`
* Define a variable `MAIL_DOMAIN` in your `.env`.
* Be sure to set your `APP_NAME` to the name of your app.
* Fill in a working mail configuration, e.g. [through mailtrap.io](https://github.com/oschettler/knowfox/wiki/How-to-install-Knowfox-at-Uberspace)

## Credits

The [approach follows a blog post by Matt Stauffer](https://tighten.co/blog/creating-a-password-less-medium-style-email-only-authentication-system-in-laravel).

# Inpsyde-Exam
Plugin creation exam for Inpsyde

# Disclaimer
Nickan and mcolete are my usernames, I created the README.md on the browser using Nickan which I think I shouldn't, that's why it seems like a collaborative effort, sorry for the confusion.

# Requirements:
- PHP 7.2
- Wordpress 5.4.1

# Installation
- Clone the repository
- Type in the root plugin directory:
```
$ composer install
```
- Add in wp-config.php to control loading of Composer autoload
```
define( 'IS_AUTOLOADING', true );
```
- Copy to the Wordpress plugin directory
- Log in to Wordpress Admin page
- Go to Plugin
- Find "Inpsyde Exam"
- Then click enable
- Type {Home URL}/users in the browser (Ex: "http://localhost/users)

# HTTP Cache
- Used guzzlehttp/guzzle, kevinrob/guzzle-cache-middleware and league/flysystem.
- I tried a lot of other options to cache, even play with basic curl options, but none of them gives an easy indicator that it is really caching.
- Using kevinrob/guzzle-cache-middleware, it will create files inside "inpsyde-exam/tmp" folder
- Since we are just using GET, 60 TTL seems to be a good tradeoff in general but still depends on many factors.

# Other Composer Packages
- PHP Unit(phpunit/phpunit) For Unit and integration testing
- Inpsyde PHP Coding Standards (inpsyde/php-coding-standards) for testing coding convention

# Non-obvious Implementation Choices
- I used basic php page routing for custom endpoint.

# Possible Errors
- If HTTP caching won't work due to "/tmp" folder not created, please set the directory permission 
- On Firefox it works perfectly.
- On Google Chrome sometimes won't load the page when typing shortcut URL in address bar (Ex: localhost/users).
- But typing the whole URL is fine (http://localhost/users), though in console it shows 404 for /users.
- CORS issues which happens every now and then, probably the server in jsonplaceholder sets randomly? The plugin handles it well.

# Know Issues in Coding Convention


- I am unable to issues below, which I admit defeat despite my Level 60 Googling Skills:
<details><summary>CLICK ME</summary>

```
 16 | ERROR | Class 'Inpsyde\Model\Users', located at
    |       | '/home/src/wordpress/wp-content/plugins/inpsyde-exam/src/model/Users.php', is not
    |       | compliant with PSR-4 configuration. (Inpsyde.CodeQuality.Psr4.InvalidPSR4)
```

</details>

- And this one:

<details><summary>CLICK ME</summary>

````
 18 | ERROR   | Class 'Inpsyde\Inpsyde', located at
    |         | '/home/src/wordpress/wp-content/plugins/inpsyde-exam/src/Inpsyde.php', is not
    |         | compliant with PSR-4 configuration. (Inpsyde.CodeQuality.Psr4.InvalidPSR4)
 29 | WARNING | Detected access of super global var $_SERVER, probably needs manual inspection.
    |         | (WordPress.VIP.SuperGlobalInputUsage.AccessDetected)
 30 | WARNING | Detected access of super global var $_SERVER, probably needs manual inspection.
    |         | (WordPress.VIP.SuperGlobalInputUsage.AccessDetected)
 30 | ERROR   | Missing wp_unslash() before sanitization. (WordPress.VIP.ValidatedSanitizedInput.MissingUnslash)
````
</details>

- So I cleaned the data first and asked the God sent forum: https://stackoverflow.com/questions/62112780/error-class-path-is-not-compliant-with-psr-4-configuration-inpsyde-codequal?noredirect=1#comment109854819_62112780
- And https://stackoverflow.com/questions/62115353/detected-access-of-super-global-var-server-probably-needs-manual-inspection-a
- I hope that I didn't violate your rules, I will just edit the question if I did and/or ask the moderator to remove it.


# License

https://opensource.org/licenses/MIT
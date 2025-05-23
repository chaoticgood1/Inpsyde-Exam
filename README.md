# Inpsyde-Exam
Plugin creation exam for Inpsyde

# Disclaimer
Nickan and mcolete are my usernames, I created the README.md on the browser using Nickan which I think I shouldn't, that's why it seems like a collaborative effort, sorry for the confusion.

# Requirements:
- PHP 7.2
- Wordpress 5.4.1

# Installation
- Clone the repository to wordpress plugin directory
- Type in the root plugin directory:
```
$ composer install
```
- Log in to Wordpress Admin page
- Go to Plugin
- Find "Inpsyde Exam"
- Then click enable
- Type {Home URL}/users in the browser (Ex: "http://localhost/users)


# Testing Code Convention and Unit Test
- In the root plugin folder, enter:
```
$ vendor/bin/phpcs
$ vendor/bin/phpunit
```

# HTTP Cache
- Passed "Cache-Control" => "max-age=60" to wp_safe_remote_get(), but I can't seem to find a way to test it, will research it in my free time.

# Other Composer Packages
- PHP Unit(phpunit/phpunit) For Unit and integration testing
- Inpsyde PHP Coding Standards (inpsyde/php-coding-standards) for testing coding convention
- BrainMonkey by Mr. Giuseppe

# Non-obvious Implementation Choices
- I used basic php page routing for custom endpoint.

# Known Errors
- After doing installation and it doesn't load, please check directory permission
- Or you might need to add these in the .htaccess in the Wordpress root directory
```
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>

# END WordPress
```
- If HTTP caching won't work due to "/tmp" folder not created, please set the directory permission 
- On Firefox it works perfectly.
- On Google Chrome sometimes won't load the page when typing shortcut URL in address bar (Ex: localhost/users).
- But typing the whole URL is fine (http://localhost/users), though in console it shows 404 for /users.
- CORS issues which happens every now and then, probably the server in jsonplaceholder sets randomly? The plugin handles it well.
- If in case there is a missing package error which didn't executed the dumpautoload automatically, manually run:
```
$ composer dumpautoload -o
```

# Known Issues in Coding Convention


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

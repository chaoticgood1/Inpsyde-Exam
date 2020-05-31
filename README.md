# Inpsyde-Exam
Plugin creation exam for Inpsyde

# Requirements:
- PHP 7.2
- Wordpress 5.4.1

# Installation
- In progress... (Implement composer load in wp-config.php to load this plugin)
- Clone the repository
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

# Possible Error
- If HTTP caching won't work due to "/tmp" folder not created, please set the directory permission 

# Extra Notes
- On Firefox it works perfectly.
- On Google Chrome sometimes won't load the page when typing shortcut URL in address bar (Ex: localhost/users).
- But typing the whole URL is fine (http://localhost/users), though in console it shows 404 for /users.

# License

https://opensource.org/licenses/MIT


// TODO:
- Requirements 
- Installation and usage instruction
- Explanations behind non-obvious implementation choices
- Your composer.json is valid and complete, and running composer install makes the plugin ready to be used.

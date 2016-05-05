# php7-file-config
A simple Utility Class for handling configurations as .php files (key to value) for **PHP7** working.


## LICENSE
[MIT](https://github.com/CoNfu5eD/php-file-config/blob/master/LICENSE)

## FAQ

### Why .php files?

There are more than one reason for using .php files but most important is **security**.
When we would use JSON or XML for example it would be static files which are public reachable.
Of course you can protect them with .htaccess file but think about you update your server for example
you want to send static files with NGINX now but don`t know NGINX isn´t supporting .htaccess files.
As long as you did not added a .ht file for NGINX your configuration is public reachable!
So we create .php files to be more on the secure site because they are parsed by server
and will not be send to the client as long as your server configuration isn´t totally incorrect.

And **performance** is also a reason of course .php files should be faster on loading then JSON or XML which booth needs to be parsed by php (benchmark will be added later).

### What scalar types are supported for value?

Actually it supports all scalar types supported by [var_export](https://secure.php.net/manual/en/function.var-export.php) which also includes arrays and objects.

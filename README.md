# Pizzeria La Cannata

A simple PHP application demonstrating a small ordering system with a menu and cart.

## Requirements

- PHP 8.1+ with the PDO MySQL extension
- A MySQL database with the required tables
- A web server such as Apache or the built in PHP development server

## Setup

1. Clone the repository or download the source code.
2. Configure the database connection. You can set the environment variables
   `DB_HOST`, `DB_NAME`, `DB_USER` and `DB_PASS` or provide a PHP file returning
   the configuration array.
   Copy `src/config.sample.php` somewhere outside the web root, adjust the
   values and set the path in the `DB_CONFIG_FILE` environment variable.

Example configuration file:

```php
<?php
return [
    'db_host' => 'localhost',
    'db_name' => 'pizzeria',
    'db_user' => 'user',
    'db_pass' => 'secret',
];
```

## Running the application

From the project root you can start the PHP development server:

```bash
php -S localhost:8000
```

Then open <http://localhost:8000> in your browser.

When deploying with Apache make sure mod_rewrite is enabled and that the
provided `.htaccess` file is used so that all requests are routed to
`index.php`.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE)
file for details.


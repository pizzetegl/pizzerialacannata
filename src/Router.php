<?php
namespace App;

class Router
{
    protected array $routes = [];

    public function __construct()
    {
        // registra qui le tue rotte
        $this->routes = [
            ['GET', '/', 'App\Controllers\MenuController@index'],
            ['POST', '/cart/add', 'App\Controllers\CartController@add'],
            ['GET', '/cart', 'App\Controllers\CartController@index'],
            // aggiungerai altre rotte per cart, checkout, admin…
        ];
    }

    public function dispatch(string $path, string $method)
    {
        // Use the normalized path from index.php
        if ($path === '' || $path === false) {
            $path = '/';
        }

        foreach ($this->routes as [$m, $route, $handler]) {
            if ($m === $method && preg_match("#^{$route}$#", $path, $matches)) {
                [$class, $action] = explode('@', $handler);
                $params = array_slice($matches, 1);
                return (new $class)->$action(...$params);
            }
        }
        http_response_code(404);
        echo "Pagina non trovata";
    }
}
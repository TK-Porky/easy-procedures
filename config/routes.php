<?php

/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes) {
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder) {
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/landing_page.php)...
         */
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

        /*
         * Auth controller routes (Deprecated - now moved to prefixes)
         */
        //$builder->connect('/login', ['controller' => 'Auth', 'action' => 'login']);
        //$builder->connect('/register', ['controller' => 'Auth', 'action' => 'register']);
        //$builder->connect('/forgetpassword', ['controller' => 'Auth', 'action' => 'forgetpassword']);
        //$builder->connect('/verify', ['controller' => 'Auth', 'action' => 'verify']);


        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        $builder->connect('/pages/*', 'Pages::display');

        /*
         * Catchall routes removed - everything moved to prefixes
         */
       
        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * You can remove these routes once you've connected the
         * routes you want in your application.
         */
        $builder->fallbacks();
    });

    /**
     * Swagger UI route
     */
    $routes->connect('/swagger', [
        'plugin' => 'SwaggerBake',
        'controller' => 'Swagger',
        'action' => 'index'
    ]);

    /*
     * Scopes par rôle (Prefix Routing)
     */
    $routes->prefix('Admin', function (RouteBuilder $builder) {
        // Auth routes for Admin
        $builder->connect('/login', ['controller' => 'Auth', 'action' => 'login']);
        $builder->connect('/logout', ['controller' => 'Auth', 'action' => 'logout']);

        // Toutes les routes /admin iront vers le dossier src/Controller/Admin
        $builder->connect('/', ['controller' => 'Dashboard', 'action' => 'index']);

        $builder->connect(
            '/requirements/properties/index/{id}',
            ['controller' => 'Requirementproprieties', 'action' => 'index'],
            ['id' => '\d+', 'pass' => ['id']]
        );

        $builder->connect(
            '/procedures/properties/{id}',
            ['controller' => 'Procedurerequirements', 'action' => 'index'],
            ['id' => '\d+', 'pass' => ['id']]
        );

        $builder->fallbacks(DashedRoute::class);
    });


    $routes->prefix('Agent', function (RouteBuilder $builder) {
        // Auth routes for Agent
        $builder->connect('/login', ['controller' => 'Auth', 'action' => 'login']);
        $builder->connect('/logout', ['controller' => 'Auth', 'action' => 'logout']);

        // Toutes les routes /agent iront vers le dossier src/Controller/Agent
        $builder->connect('/', ['controller' => 'Dashboard', 'action' => 'index']);
        $builder->fallbacks(DashedRoute::class);
    });


    $routes->prefix('Client', function (RouteBuilder $builder) {
        // Auth routes for Client
        $builder->connect('/login', ['controller' => 'Auth', 'action' => 'login']);
        $builder->connect('/logout', ['controller' => 'Auth', 'action' => 'logout']);
        $builder->connect('/register', ['controller' => 'Auth', 'action' => 'register']);
        $builder->connect('/verify/*', ['controller' => 'Auth', 'action' => 'verify']);
        $builder->connect('/forgot-password', ['controller' => 'Auth', 'action' => 'forgetpassword']);

        // Toutes les routes /client iront vers le dossier src/Controller/Client
        $builder->connect('/', ['controller' => 'Dashboard', 'action' => 'index']);
        $builder->fallbacks(DashedRoute::class);
    });


    /*
     * API scope
     */
    $routes->scope('/api/v1', function (RouteBuilder $builder) {
        $builder->setExtensions(['json']);
        
        // Auth API
        $builder->connect('/users/login', ['controller' => 'Users', 'action' => 'login', 'prefix' => 'Api/V1']);
        $builder->connect('/users/register', ['controller' => 'Users', 'action' => 'register', 'prefix' => 'Api/V1']);
        $builder->connect('/users/forget-password', ['controller' => 'Users', 'action' => 'forgetPassword', 'prefix' => 'Api/V1']);
        
        // Resource routes
        $builder->resources('Procedures', [
            'prefix' => 'Api/V1'
        ]);
        $builder->resources('Requests', [
            'prefix' => 'Api/V1'
        ]);
        $builder->resources('Requirements', [
            'prefix' => 'Api/V1'
        ]);
        
        $builder->fallbacks();
    });

    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder) {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
};

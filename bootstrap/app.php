<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(dirname(__DIR__)))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

 $app->withFacades(true, [
     'GrahamCampbell\Flysystem\Facades\Flysystem' => 'Flysystem',
     'Intervention\Image\Facades\Image' => 'Image',
     'Barryvdh\DomPDF\Facade' => 'PDF',
 ]);

 $app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

$app->middleware([
    App\Http\Middleware\CorsMiddleware::class,
]);

 $app->routeMiddleware([
     'auth' => App\Http\Middleware\Authenticate::class,
 ]);

$app->routeMiddleware([
    'valid' => App\Http\Middleware\ValidationRequestMiddleware::class,
]);

$app->routeMiddleware([
    'device' => App\Http\Middleware\DeviceMiddleware::class,
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

 $app->register(App\Providers\AppServiceProvider::class);
 $app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);

// Lumen Generator
$app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);

// Firebase
//$app->register(SafeStudio\Firebase\FirebaseServiceProvider::class);
////class_alias(SafeStudio\Firebase\Facades\FirebaseFacades::class, 'Firebase');

// Storage
$app->register(GrahamCampbell\Flysystem\FlysystemServiceProvider::class);

// Intervention Image Package
$app->register(Intervention\Image\ImageServiceProvider::class);

// PDF
$app->register(\Barryvdh\DomPDF\ServiceProvider::class);

//Mail
$app->register(Illuminate\Mail\MailServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});


// Lumen Passport
$app->register(Laravel\Passport\PassportServiceProvider::class);
$app->register(Dusterio\LumenPassport\PassportServiceProvider::class);

$app->configure('auth');
$app->configure('services');
$app->configure('mail');
$app->configure('dompdf');


return $app;

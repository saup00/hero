<?php
require_once __DIR__.'/../vendor/autoload.php';
 
use Symfony\Component\HttpFoundation\Request;
 
$app = new Silex\Application();
$app['debug'] = true;
 
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/views',));

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admin' => array(
            'pattern' => '^/admin/',
            'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check'),
            'logout' => array('logout_path' => '/admin/logout'),
            'users' => array(
                'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
            ),
        ),
    )
));
 
$app->get('/', function () use ($app) {
    $user = $app['session']->get('user');
    return $app['twig']->render('index.html', array('user' => $user));
});
 
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
});
 
$app->get('/admin', function () use ($app) {
    return 'Admin site';
});
 
$app->run();
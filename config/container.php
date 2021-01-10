<?php

use App\Factory\LoggerFactory;
use App\Service\VersionService;
use Odan\Session\PhpSession;
use Odan\Session\SessionInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteParserInterface;
use Slim\Middleware\ErrorMiddleware;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Factory\UriFactory;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Slim\Views\TwigMiddleware;
use Slim\Views\TwigRuntimeLoader;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    LoggerFactory::class => function (ContainerInterface $container) {
        return new LoggerFactory($container->get('settings')['logger']);
    },

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    },

    StreamFactoryInterface::class => function () {
        return new StreamFactory();
    },

    RouteParserInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getRouteCollector()->getRouteParser();
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },

    TwigMiddleware::class => function (ContainerInterface $container) {
        return TwigMiddleware::createFromContainer($container->get(App::class), Twig::class);
    },

    // Twig templates
    Twig::class => function (ContainerInterface $container) {
        $settings = (array)$container->get('settings');
        $twigSettings = $settings['twig'];

        $options = $twigSettings['options'];
        $options['cache'] = $options['cache_enabled'] ? $options['cache_path'] : false;

        $twig = Twig::create($twigSettings['paths'], $options);

        $loader = $twig->getLoader();
        $publicPath = (string)$settings['public'];
        if ($loader instanceof FilesystemLoader) {
            $loader->addPath($publicPath, 'public');
        }

        // Add extensions
        //$twig->addExtension(new TranslationExtension($container->get(Translator::class)));
        //$twig->addExtension(new WebpackExtension($publicPath . '/assets/manifest.json', $publicPath));

        // Add the Twig extension only if we run the application from the command line / cron job,
        // but not when phpunit tests are running.
        if ((PHP_SAPI === 'cli') && !isset($_ENV['PHPUNIT_TEST_SUITE'])) {
            $app = $container->get(App::class);
            $routeParser = $app->getRouteCollector()->getRouteParser();
            $uri = (new UriFactory())->createUri('http://localhost');

            $runtimeLoader = new TwigRuntimeLoader($routeParser, $uri);
            $twig->addRuntimeLoader($runtimeLoader);
            $twig->addExtension(new TwigExtension());
        }

        $flash = $container->get(SessionInterface::class)->getFlash();

        $environment = $twig->getEnvironment();
        $environment->addGlobal('flash', $flash);

        $environment->addFunction(
            new TwigFunction(
                'flashes',
                function (string $key, $default = null) use ($flash) {
                    return $flash->get($key, $default ?? []);
                }
            )
        );

        return $twig;
    },

    SessionInterface::class => function (ContainerInterface $container) {
        $settings = $container->get('settings');
        $session = new PhpSession();
        $session->setOptions((array)$settings['session']);

        return $session;
    },

    PDO::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['db'];

        $host = $settings['host'];
        $dbname = $settings['database'];
        $username = $settings['username'];
        $password = $settings['password'];
        $charset = $settings['charset'];
        $flags = $settings['flags'];
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

        return new PDO($dsn, $username, $password, $flags);
    },

    VersionService::class => function (ContainerInterface $container) {
        return new VersionService();
    },
];

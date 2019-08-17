<?php declare(strict_types = 1);

namespace Statico\Core;

use Zend\Diactoros\ServerRequestFactory;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionClass;
use Statico\Core\Application;

/**
 * Application instance
 */
final class Application
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var \League\Route\Router
     */
    private $router;

    /**
     * @var array
     */
    private $providers = [
        'Statico\Core\Providers\ContainerProvider',
        'Statico\Core\Providers\CacheProvider',
        'Statico\Core\Providers\ConfigProvider',
        'Statico\Core\Providers\EventProvider',
        'Statico\Core\Providers\FlysystemProvider',
        'Statico\Core\Providers\FormsProvider',
        'Statico\Core\Providers\HandlerProvider',
        'Statico\Core\Providers\LoggerProvider',
        'Statico\Core\Providers\RouterProvider',
        'Statico\Core\Providers\SessionProvider',
        'Statico\Core\Providers\SitemapGeneratorProvider',
        'Statico\Core\Providers\SourceProvider',
        'Statico\Core\Providers\TwigProvider',
        'Statico\Core\Providers\TwigLoaderProvider',
        'Statico\Core\Providers\ViewProvider',
        'Statico\Core\Providers\YamlProvider',
        'Statico\Core\Providers\MailerProvider',
    ];

    public function __construct(Container $container = null)
    {
        if (!$container) {
            $container = new Container();
        }
        $this->container = $container;
    }

    /**
     * Bootstrap the application
     *
     * @return Application
     */
    public function bootstrap(): Application
    {
        $this->setupContainer();
        $this->setErrorHandler();
        $this->setupRoutes();
        return $this;
    }

    /**
     * Handle a request
     *
     * @param ServerRequestInterface $request HTTP request.
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        try {
            $response = $this->router->dispatch($request);
        } catch (\League\Route\Http\Exception\NotFoundException $e) {
            $view = $this->container->get('Statico\Core\Contracts\Views\Renderer');
            $response = $view->render(
                $this->container->get('response')->withStatus(404),
                '404.html'
            );
        }
        return $response;
    }

    private function setupContainer(): void
    {
        $container = $this->container;
        $container->delegate(
            new ReflectionContainer()
        );

        foreach ($this->providers as $provider) {
            $container->addServiceProvider($provider);
        }
        $container->share('response', \Zend\Diactoros\Response::class);
        $container->share('Psr\Http\Message\ResponseInterface', \Zend\Diactoros\Response::class);
        $this->container = $container;
    }

    private function setErrorHandler(): void
    {
        error_reporting(E_ALL);
        $environment = getenv('APP_ENV');

        $whoops = new \Whoops\Run();
        if ($environment !== 'production') {
            $whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler());
        } else {
            $handler = $this->container->get('Statico\Core\Contracts\Exceptions\Handler');
            $whoops->prependHandler(new \Whoops\Handler\CallbackHandler($handler));
        }
        $whoops->register();
    }

    private function setupRoutes(): void
    {
        $router = $this->container->get('League\Route\Router');
        $router->get('/[{name:[a-zA-Z0-9\-\/]+}]', 'Statico\Core\Http\Controllers\MainController::index')
            ->middleware(new \Statico\Core\Http\Middleware\ETag());
        $router->post('/[{name:[a-zA-Z0-9\-\/]+}]', 'Statico\Core\Http\Controllers\MainController::submit');
        $this->router = $router;
    }

    public function getContainer(): Container
    {
        return $this->container;
    }
}

<?php

declare(strict_types=1);

namespace Statico\Core\Kernel;

use Laminas\Diactoros\ServerRequestFactory;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Psr\Http\Message\ServerRequestInterface;
use Statico\Core\Kernel\Application;
use Statico\Core\Exceptions\Plugins\PluginNotFound;
use Statico\Core\Exceptions\Plugins\PluginNotValid;
use Statico\Core\Contracts\Kernel\KernelInterface;

/**
 * Application instance
 */
final class Application implements KernelInterface
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
                          'Statico\Core\Providers\ClockworkProvider',
                          'Statico\Core\Providers\ConfigProvider',
                          'Statico\Core\Providers\ConsoleProvider',
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
                          'Statico\Core\Providers\GlideProvider',
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
        $this->setupPlugins();
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
        if (getenv('APP_ENV') == 'development') {
            $clockwork = $this->container->get('Clockwork\Support\Vanilla\Clockwork');
            $clockwork->requestProcessed();
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
        $container->share('response', \Laminas\Diactoros\Response::class);
        $container->share('Psr\Http\Message\ResponseInterface', \Laminas\Diactoros\Response::class);
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
        if (getenv('APP_ENV') == 'development') {
            $router->get('/__clockwork/{request:.+}', 'Statico\Core\Http\Controllers\ClockworkController::process');
        }
        $router->get('/images/[{name}]', 'Statico\Core\Http\Controllers\ImageController::get');
        $router->get('/[{name:[a-zA-Z0-9\-\/]+}]', 'Statico\Core\Http\Controllers\MainController::index')
            ->middleware(new \Statico\Core\Http\Middleware\HttpCache())
            ->middleware(new \Statico\Core\Http\Middleware\ETag());
        $router->post('/[{name:[a-zA-Z0-9\-\/]+}]', 'Statico\Core\Http\Controllers\MainController::submit');
        $this->router = $router;
    }

    private function setupPlugins(): void
    {
        $config = $this->container->get('PublishingKit\Config\Config');
        if (!$plugins = $config->get('plugins')) {
            return;
        }
        foreach ($plugins as $name) {
            if (!$plugin = $this->container->get($name)) {
                throw new PluginNotFound('Plugin could not be resolved by the container');
            }
            if (!in_array('Statico\Core\Contracts\Plugin', array_keys(class_implements($name)))) {
                throw new PluginNotValid('Plugin does not implement Statico\Core\Contracts\Plugin');
            }
            $plugin->register();
        }
    }

    public function getContainer(): Container
    {
        return $this->container;
    }
}

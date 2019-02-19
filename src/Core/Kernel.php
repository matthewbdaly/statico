<?php declare(strict_types = 1);

namespace Statico\Core;

use Zend\Diactoros\ServerRequestFactory;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Psr\Http\Message\RequestInterface;
use ReflectionClass;
use Statico\Core\Utilities\PluginCollection;

/**
 * Application kernel
 */
final class Kernel
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var League\Route\Router
     */
    private $router;

    /**
     * @var PluginCollection
     */
    private $plugins;

    /**
     * @var Providers
     */
    private $providers = [
        'Statico\Core\Providers\ContainerProvider',
        'Statico\Core\Providers\CacheProvider',
        'Statico\Core\Providers\ConfigProvider',
        'Statico\Core\Providers\EventProvider',
        'Statico\Core\Providers\FlysystemProvider',
        'Statico\Core\Providers\HandlerProvider',
        'Statico\Core\Providers\LoggerProvider',
        'Statico\Core\Providers\ResolverProvider',
        'Statico\Core\Providers\RouterProvider',
        'Statico\Core\Providers\TwigProvider',
        'Statico\Core\Providers\TwigLoaderProvider',
        'Statico\Core\Providers\ViewProvider',
        'Statico\Core\Providers\YamlProvider',
    ];

    public function __construct(Container $container = null)
    {
        if (!$container) {
            $container = new Container;
        }
        $this->container = $container;
        $this->plugins = new PluginCollection([]);
    }

    /**
     * Bootstrap the application
     *
     * @return Kernel
     */
    public function bootstrap(): Kernel
    {
        $this->setupContainer();
        $this->setErrorHandler();
        $this->registerPlugins();
        $this->setupRoutes();
        return $this;
    }

    /**
     * Handle a request
     *
     * @param RequestInterface $request HTTP request.
     * @return void
     */
    public function handle(RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        try {
            $response = $this->router->dispatch($request, $this->container->get('response'));
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
            new ReflectionContainer
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

        $whoops = new \Whoops\Run;
        if ($environment !== 'production') {
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        } else {
            $handler = $this->container->get('Statico\Core\Contracts\Exceptions\Handler');
            $whoops->pushHandler(new \Whoops\Handler\CallbackHandler($handler));
        }
        $whoops->register();
    }

    private function setupRoutes(): void
    {
        $router = $this->container->get('League\Route\Router');
        require_once BASE_DIR.'/routes.php';
        $this->router = $router;
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    private function registerPlugins()
    {
        foreach ($this->getPlugins() as $pluginClass) {
            $ref = new ReflectionClass($pluginClass);
            if (!$ref->implementsInterface('Statico\Core\Contracts\Extension\Plugin')) {
                continue;
            }
            $plugin = $this->container->get($pluginClass);
            $plugin->register();
            $this->plugins[] = $plugin;
        }
    }

    public function getRegisteredPlugins()
    {
        return $this->plugins;
    }

    private function getPlugins()
    {
        $reader = $this->container->get('Zend\Config\Reader\ReaderInterface');
        $config = $reader->fromFile(BASE_DIR.'/config.yml');
        return $config['plugins'];
    }
}

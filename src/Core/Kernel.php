<?php declare(strict_types = 1);

namespace Statico\Core;

use Zend\Diactoros\ServerRequestFactory;
use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Route\Strategy\ApplicationStrategy;
use Psr\Http\Message\RequestInterface;

/**
 * Application kernel
 */
class Kernel
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var Providers
     */
    private $providers = [
        'Statico\Core\Providers\ContainerProvider',
        'Statico\Core\Providers\CacheProvider',
        'Statico\Core\Providers\EventProvider',
        'Statico\Core\Providers\FlysystemProvider',
        'Statico\Core\Providers\HandlerProvider',
        'Statico\Core\Providers\LoggerProvider',
        'Statico\Core\Providers\RouterProvider',
        'Statico\Core\Providers\TwigProvider',
    ];

    /**
     * Bootstrap the application
     *
     * @return Kernel
     */
    public function bootstrap(): Kernel
    {
        $this->setupContainer();
        $this->setupRoutes();
        $this->setErrorHandler();
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
            $twig = $this->container->get('Twig_Environment');
            $tpl = $twig->load('404.html');
            $response = $this->container->get('response')->withStatus(404);
            $response->getBody()->write($tpl->render());
        }
        return $response;
    }

    private function setupContainer(): void
    {
        $container = new Container;
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
        $strategy = (new ApplicationStrategy)->setContainer($this->container);
        $router = $this->container->get('League\Route\Router')
            ->setStrategy($strategy);
        require_once BASE_DIR.'/routes.php';
        $this->router = $router;
    }

    public function getContainer(): Container
    {
        return $this->container;
    }
}

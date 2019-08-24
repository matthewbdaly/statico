<?php declare(strict_types=1);

namespace Statico\Core\Utilities\Traits;

use BadMethodCallException;
use ReflectionClass;
use ReflectionMethod;
use Closure;

trait Macroable
{
    /**
     * @var array
     */
    protected static $macros = [];

    /**
     * Define a macro
     *
     * @param string   $name  Name of macro.
     * @param callable $macro Callable to run.
     * @return void
     */
    public static function macro(string $name, callable $macro)
    {
        static::$macros[$name] = $macro;
    }

    /**
     * Mix another object into the class.
     *
     * @param  object  $mixin
     * @param  bool  $replace
     * @return void
     *
     * @throws \ReflectionException
     */
    public static function mixin($mixin, $replace = true)
    {
        $methods = (new ReflectionClass($mixin))->getMethods(
            ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED
        );
        foreach ($methods as $method) {
            if ($replace || !static::hasMacro($method->name)) {
                $method->setAccessible(true);
                static::macro($method->name, function() use ($method, $mixin) {
                    return $method->invoke($mixin);
                });
            }
        }
    }

    /**
     * Call macro methods
     *
     * @param mixed $method     Method to call.
     * @param mixed $parameters Any parameters set.
     * @return mixed
     * @throws BadMethodCallException Called method is not defined.
     */
    public function __call($method, $parameters)
    {
        if (!static::hasMacro($method)) {
            throw new BadMethodCallException("Method {$method} does not exist.");
        }

        if (static::$macros[$method] instanceof Closure) {
            return call_user_func_array(static::$macros[$method]->bindTo($this, static::class), $parameters);
        }

        return call_user_func_array(static::$macros[$method], $parameters);
    }

    /**
     * Dynamically handle calls to the class.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public static function __callStatic($method, $parameters)
    {
        if (!static::hasMacro($method)) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.',
                static::class,
                $method
            ));
        }

        if (static::$macros[$method] instanceof Closure) {
            return call_user_func_array(Closure::bind(static::$macros[$method], null, static::class), $parameters);
        }

        return call_user_func_array(static::$macros[$method], $parameters);
    }

    /**
     * Is a given macro defined?
     *
     * @param string $name Name of macro.
     * @return boolean
     */
    public static function hasMacro(string $name)
    {
        return isset(static::$macros[$name]);
    }
}

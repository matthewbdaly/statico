<?php declare(strict_types=1);

namespace Statico\Core\Utilities\Traits;

use BadMethodCallException;

trait IsMacroable
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
     * Call macro methods
     *
     * @param mixed $method     Method to call.
     * @param mixed $parameters Any parameters set.
     * @return mixed
     * @throws BadMethodCallException Called method is not defined.
     */
    public function __call($method, $parameters)
    {
        if (! static::hasMacro($method)) {
            throw new BadMethodCallException("Method {$method} does not exist.");
        }

        if (is_callable(static::$macros[$method])) {
            return call_user_func_array(static::$macros[$method]->bindTo($this, static::class), $parameters);
        }

        return call_user_func_array(static::$macros[$method], $parameters);
    }

    /**
     * Is a given macro defined?
     *
     * @param string $name Name of macro.
     * @return boolean
     */
    protected function hasMacro(string $name)
    {
        return isset(static::$macros[$name]);
    }
}

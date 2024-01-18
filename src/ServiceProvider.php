<?php

namespace Cove\MacroAttributes;

use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Support\ServiceProvider as LaravelProvider;
use ReflectionClass;
use ReflectionMethod;
use Cove\MacroAttributes\Attributes\Macro;
use Cove\MacroAttributes\Attributes\Mixin;

class ServiceProvider extends LaravelProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/macros.php' => config_path('macros.php'),
        ], 'macros-config');

        foreach ($this->classes() as $class) {
            $reflectionClass = new ReflectionClass($class);
            $this->registerMacros($reflectionClass);
            $this->registerMixins($reflectionClass);
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/macros.php', 'macros');
    }

    protected function classes(): array
    {
        /** @var \Illuminate\Contracts\Config\Repository $config */
        $config = $this->app['config'];
        $namespaces = $config->get('macros.namespaces');
        $recursive = $config->get('macros.recursive');

        ClassFinder::disableClassmapSupport();

        return array_reduce($namespaces, function (array $carry, string $namespace) use ($recursive): array {
            $classes = ClassFinder::getClassesInNamespace(
                $namespace,
                $recursive ? ClassFinder::RECURSIVE_MODE : ClassFinder::STANDARD_MODE
            );

            return [...$carry, ...$classes];
        }, []);
    }

    protected function registerMacros(ReflectionClass $reflectionClass): void
    {
        foreach ($reflectionClass->getMethods() as $method) {
            $macroAttributes = $method->getAttributes(Macro::class);

            foreach ($macroAttributes as $reflectionAttribute) {
                /** @var \Cove\MacroAttributes\Attributes\Macro $attribute */
                $attribute = $reflectionAttribute->newInstance();
                $methodName = $method->getName();
                $class = $this->app->make($reflectionClass->getName());

                ($attribute->target)::macro($methodName, $method->invoke($class));
            }
        }
    }

    protected function registerMixins(ReflectionClass $reflectionClass): void
    {
        $mixinAttributes = $reflectionClass->getAttributes(Mixin::class);

        foreach ($mixinAttributes as $mixinAttribute) {
            /** @var \Cove\MacroAttributes\Attributes\Mixin $attribute */
            $attribute = $mixinAttribute->newInstance();
            $class = $this->app->make($reflectionClass->getName());

            ($attribute->target)::mixin($class, $attribute->replace);
        }
    }
}

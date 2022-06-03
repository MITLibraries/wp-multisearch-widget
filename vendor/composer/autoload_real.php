<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit37f9918603dbdf904df28ca85e60354d
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit37f9918603dbdf904df28ca85e60354d', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit37f9918603dbdf904df28ca85e60354d', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit37f9918603dbdf904df28ca85e60354d::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
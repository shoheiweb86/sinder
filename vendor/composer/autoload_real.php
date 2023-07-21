<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit923100a1c62b7d34041783b3f9778d9d
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

        spl_autoload_register(array('ComposerAutoloaderInit923100a1c62b7d34041783b3f9778d9d', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit923100a1c62b7d34041783b3f9778d9d', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit923100a1c62b7d34041783b3f9778d9d::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}

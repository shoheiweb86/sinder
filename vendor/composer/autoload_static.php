<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit923100a1c62b7d34041783b3f9778d9d
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit923100a1c62b7d34041783b3f9778d9d::$classMap;

        }, null, ClassLoader::class);
    }
}

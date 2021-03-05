<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9235de74f19c80f9cdc9736bb6185d09
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9235de74f19c80f9cdc9736bb6185d09::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9235de74f19c80f9cdc9736bb6185d09::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9235de74f19c80f9cdc9736bb6185d09::$classMap;

        }, null, ClassLoader::class);
    }
}

<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitcb6ab077334d6b1724e3184ff6e66bdd
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitcb6ab077334d6b1724e3184ff6e66bdd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitcb6ab077334d6b1724e3184ff6e66bdd::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitcb6ab077334d6b1724e3184ff6e66bdd::$classMap;

        }, null, ClassLoader::class);
    }
}

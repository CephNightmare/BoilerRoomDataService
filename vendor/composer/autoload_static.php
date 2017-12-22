<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7388d52b65ccaf5769c66e493bdcfbb6
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

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7388d52b65ccaf5769c66e493bdcfbb6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7388d52b65ccaf5769c66e493bdcfbb6::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

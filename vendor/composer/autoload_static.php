<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit54061c92c31747c86b13df7cc73cf265
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit54061c92c31747c86b13df7cc73cf265::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit54061c92c31747c86b13df7cc73cf265::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit231693c493174c829c42865d0d3a32c7
{
    public static $files = array (
        'f6d4f6bcee7247df6b777884c3e22f98' => __DIR__ . '/..' . '/yahnis-elsts/plugin-update-checker/load-v5p6.php',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit231693c493174c829c42865d0d3a32c7::$classMap;

        }, null, ClassLoader::class);
    }
}

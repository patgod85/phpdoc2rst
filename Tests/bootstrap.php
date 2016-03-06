<?php

/**
 * Bootstrap file for the test suite
 */

if (is_readable(__DIR__ . '/../vendor/autoload.php'))
{
    /** @var \Composer\Autoload\ClassLoader $loader */
    $loader = include __DIR__ . '/../vendor/autoload.php';
    $loader->add('Patgod85', __DIR__.'/../');
    $loader->add('input', __DIR__.'/../Resources/test');
}

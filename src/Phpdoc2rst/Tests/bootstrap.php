<?php

/**
 * Bootstrap file for the test suite
 */

if (is_readable(__DIR__ . '/../../../vendor/autoload.php'))
{
    /** @var \Composer\Autoload\ClassLoader $loader */
    $loader = include __DIR__ . '/../../../vendor/autoload.php';
    $loader->add('Phpdoc2rst', __DIR__.'/../../../src');
}

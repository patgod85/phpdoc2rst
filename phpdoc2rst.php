#!/usr/bin/env php
<?php

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = include __DIR__ . '/vendor/autoload.php';
$loader->add('Phpdoc2rst', __DIR__.'/src');


use Phpdoc2rst\Process;
use Symfony\Component\Console\Application;


$application = new Application('phpdoc2rst', '1.0.0-alpha');
$application->add(new Process());
$application->run();
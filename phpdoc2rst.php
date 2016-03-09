#!/usr/bin/env php
<?php

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = include __DIR__ . '/vendor/autoload.php';
$loader->add('Phpdoc2rst', __DIR__.'/src');


use Patgod85\Phpdoc2rst\Command\ProcessCommand;
use Symfony\Component\Console\Application;


$application = new Application('phpdoc2rst:process', '');
$application->add(new ProcessCommand());
$application->run();
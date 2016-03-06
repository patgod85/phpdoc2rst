<?php

namespace Patgod85\Phpdoc2rst\Command\Process;


class TemplateManager
{
    /** @var \Twig_Environment */
    private $twig;

    function __construct()
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__.'/../../Resources/views/');

        $this->twig = new \Twig_Environment($loader, array(
            'cache' => __DIR__.'/../../var/twig',
            'auto_reload' => true,
        ));
    }

    public function render($templateName, $vars)
    {
        return $this->twig->render($templateName, $vars);
    }
}
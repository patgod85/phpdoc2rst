<?php
/**
 * Created by JetBrains PhpStorm.
 * User: victor
 * Date: 12.03.13
 * Time: 11:22
 * To change this template use File | Settings | File Templates.
 */

namespace Phpdoc2rst;


class TemplateManager
{
    /** @var \Twig_Environment */
    private $twig;

    function __construct()
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__.'/Resources/views/');

        $this->twig = new \Twig_Environment($loader, array(
            'cache' => __DIR__.'/Resources/views/compilation_cache',
            'auto_reload' => true,
        ));
    }

    public function render($templateName, $vars)
    {
        return $this->twig->render($templateName, $vars);
    }
}
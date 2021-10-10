<?php

namespace CodeEmailMKT\Infrastructure\View\Twig;

use Twig_Environment as TwigEnvironment;
use Zend\Expressive\Twig\TwigRenderer as ZendTwigRenderer;

class TwigRenderer extends ZendTwigRenderer
{
    /**
     * @return TwigEnvironment
     */
    public function getTemplate(): TwigEnvironment
    {
        return $this->template;
    }

}

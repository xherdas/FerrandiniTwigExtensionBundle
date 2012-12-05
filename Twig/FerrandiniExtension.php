<?php
/**
 * @file FerrandiniExtension.php
 *
 * @author Ariel Ferrandini <arielferrandini@gmail.com>
 */
namespace Ferrandini\Bundle\TwigExtensionBundle\Twig;

use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\ParameterBag;

class FerrandiniExtension extends \Twig_Extension
{
    /**
     * @var \Symfony\Component\Routing\Router
     */
    protected $router;

    /**
     * @param \Symfony\Component\Routing\Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'route_located' => new \Twig_Function_Method($this, 'routeLocated'),
            'convert_time' => new \Twig_Function_Method($this, 'convertTime'),
        );
    }

    /**
     * @param $route_name
     * @param \Symfony\Component\HttpFoundation\ParameterBag $parameters
     * @param $locale
     * @param bool $absolute
     *
     * @return string
     */
    public function routeLocated($route_name, ParameterBag $parameters, $locale, $absolute = false)
    {
        $parameters->set('_locale', $locale);

        foreach ($parameters as $key => $value) {
            if (mb_strpos($key, '_') === 0 && $key != '_locale') {
                $parameters->remove($key);
            }
        }

        return $this->router->generate($route_name, $parameters->all(), $absolute);
    }

    /**
     * Convert time in seconds to unit
     *
     * @param $time
     * @param string $format
     * @return string
     */
    public function convertTime($time, $format = null)
    {
        if (empty ($format)) {
            if ($time > 3600) {
                $format = 'H:i:s';
            } elseif ($time > 60) {
                $format = 'i:s';
            } else {
                $format = 's';
            }
        }

        return gmdate($format, $time);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'ferrandini_extension';
    }
}
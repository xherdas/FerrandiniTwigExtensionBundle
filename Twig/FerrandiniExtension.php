<?php
/**
 * @file FerrandiniExtension.php
 *
 * @author Ariel Ferrandini <arielferrandini@gmail.com>
 */
namespace Ferrandini\Bundle\TwigExtensionBundle\Twig;

class FerrandiniExtension extends \Twig_Extension
{   
    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'convert_time' => new \Twig_Function_Method($this, 'convertTime'),
        );
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
            if ($time >= 3600) {
                $format = 'H:i:s';
            } elseif ($time >= 60) {
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
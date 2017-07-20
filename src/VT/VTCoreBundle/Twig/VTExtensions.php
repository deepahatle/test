<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/8/16
 * Time: 7:42 PM
 */

namespace VT\VTCoreBundle\Twig;


class VTExtensions extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('hyphenate', array($this, 'hyphenateFilter')),
        );
    }

    /**
     * Function to replace all special characters by hyphen
     * @param $string
     * @param string $stringCase
     * @return mixed|string
     */
    public function hyphenateFilter($string, $stringCase="")
    {
        $string = trim($string);

        switch ($stringCase) {
            case "strtolower":
                $string = strtolower($string);
                break;

            case "strtoupper":
                $string = strtoupper($string);
                break;

            case "ucwords":
                $string = ucwords($string);
                break;

            default:
                $string = $string;
        }

        $hyphenatedString = preg_replace("![^a-zA-Z0-9-]+!i", "-", $string);
        $hyphenatedString = trim(preg_replace('/-+/', '-', $hyphenatedString), '-');

        return $hyphenatedString;
    }

    public function getName()
    {
        return 'app_extension';
    }
}
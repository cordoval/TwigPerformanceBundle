<?php

namespace Cordova\TwigPerformanceBundle\Twig\Extension;

/**
 * TPExtension
 *
 * @author Luis Cordova <cordoval@gmail.com>
 */
class TPExtension extends \Twig_Extension
{
    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName()
    {
        return 'cordovatp';
    }

    /**
     * Returns a list of twig functions.
     *
     * @return array An array
     */
    public function getFunctions()
    {
        $names = array(
            'cordovatp_deepif'  => 'deepif'
        );

        $funcs = array();
        foreach ($names as $twig => $local) {
            $funcs[$twig] = new \Twig_Function_Method($this, $local, array('is_safe' => array('html')));
        }

        return $funcs;
    }

    /**
     * Deep if with messages for each option.
     *
     * @return string The html output
     */
    public function deepif()
    {
        $numargs = func_num_args();
        $arg_list = func_get_args();
        $output = '';

        for ($i = 0; $i < $numargs; $i++) {
            $arg_list2[$i] = $arg_list[$i];
            if (defined($arg_list2[$i])) {
                $output .= $arg_list[$i]."<br />\n";
            } else {
                $output .= $arg_list[$i].".not defined<br />\n";
            }
        }
        return $output;
    }
}
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
            'doStartTimerFilter' => 'doStartTimerFilter',
            'doStopTimerFilter'  => 'doStopTimerFilter',
            'doGetTotalTime'     => 'doGetTotalTime'
        );

        $funcs = array();
        foreach ($names as $twig => $local) {
            $funcs[$twig] = new \Twig_Function_Method($this, $local, array('is_safe' => array('html')));
        }

        return $funcs;
    }

    /**
     * do Start Timer Filter
     *
     * @return boolean
     */
    public function doStartTimerFilter($label) {
        $now = microtime(true);
        if (!array_key_exists('time', $GLOBALS)) {
            $GLOBALS['time'] = array('previous','total');
        }
        if (!array_key_exists($label, $GLOBALS['time']['total')) {
            $GLOBALS['time']['total'][$label] = 0;
        }

        $GLOBALS['time']['previous'][$label] = $now;
        return true;
    }
    /**
     * do Stop Timer Filter
     *
     * @return boolean
     */
    public function doStopTimerFilter($label) {
        $now = microtime(true);
        $out = $now-$GLOBALS['time']['previous'][$label];
        $GLOBALS['time']['total'][$label] += $out;
        return $out;
    }
    /**
     * do Get Total Time
     *
     * @return boolean
     */
    public function doGetTotalTime($label) {
        return $GLOBALS['time']['total'][$label];
    }
}
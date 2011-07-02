<?php

namespace Cordova\TwigPerformanceBundle\Twig\Extension;

/**
 * TPExtension
 *
 * @author Luis Cordova <cordoval@gmail.com>
 */
class TPExtension extends \Twig_Extension
{

    protected $total_time = array();
    protected $previous_time = array();
    
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
            'dostarttimerfilter' => 'doStartTimerFilter',
            'dostoptimerfilter'  => 'doStopTimerFilter',
            'dogettotaltime'     => 'doGetTotalTime'
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

        if (!array_key_exists($label, $this->total_time)) {
            $this->total_time[$label] = 0;
        }

        $this->previous_time[$label] = $now;
        return;
    }
    /**
     * do Stop Timer Filter
     *
     * @return boolean
     */
    public function doStopTimerFilter($label) {
        $now = microtime(true);
        $out = $now - $this->previous_time[$label];
        $this->total_time[$label] += $out;
        return;
    }
    /**
     * do Get Total Time
     *
     * @return boolean
     */
    public function doGetTotalTime($label) {
        return $this->total_time[$label];
    }
}
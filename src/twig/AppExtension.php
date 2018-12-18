<?php
/**
 * Created by PhpStorm.
 * User: regagim
 * Date: 18.12.18
 * Time: 23:15
 */

namespace App\twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('date', array($this, 'dateFormat')),
        );
    }

    public function dateFormat($date)
    {
        $today = date_format($date, "d-m-Y");
        $today = 'Today '.$today;

        return $today;
    }

}
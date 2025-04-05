<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;


class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('mapStatusTrans', [$this, 'mapStatus']),
        ];
    }

    public function mapStatus($string)
    {
        return $string == '1' ? "Finished" : "Pending";
    }

}
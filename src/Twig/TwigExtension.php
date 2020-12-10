<?php

namespace App\Twig;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;

class TwigExtension extends AbstractExtension
{

    public function getFilters()
    {
        return array(
            new TwigFilter('badge', [ $this, 'badgeFunction' ], ['is_safe' => ['html']])
        );
    }

    public function badgeFunction($value)
    {
        $text = "";
        if($value == 1){
            $text = '<span class="label label-success">Active</span>';
        }else{
            $text = '<span class="label label-danger">Incative</span>';
        }
        return $text;
    }

    public function getName()
    {
        return 'badge_extension';
    }
}
<?php

namespace App\Twig;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;

class TwigExtension extends AbstractExtension
{

    public function getFilters()
    {
        return array(
            new TwigFilter('badge', [ $this, 'badgeFunction' ], ['is_safe' => ['html']]),
            new TwigFilter('booleanBadge', [ $this, 'booleanFunction' ], ['is_safe' => ['html']]),
            new TwigFilter('rating', [ $this, 'rating' ], ['is_safe' => ['html']])
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

    public function booleanFunction($value)
    {
        $text = "";
        if($value == 1){
            $text = '<span class="label label-success">Oui</span>';
        }else{
            $text = '<span class="label label-danger">Non</span>';
        }
        return $text;
    }

    public function rating($rating){

        $stars = '';
        for($i=1;$i<=5;$i++){
            ($i<=$rating) ? $checked = ' checked' : $checked = '' ;
            $stars .= '<span class="fa fa-star'.$checked.'"></span>';
        }
        return $stars;

    }

    public function getName()
    {
        return 'badge_extension';
    }

}
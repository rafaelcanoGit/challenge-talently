<?php
namespace App;

class VillaPeruana
{
    public static function of($name, $quality, $sellIn): Object
    {
        switch ($name)
        {
            case 'Pisco Peruano':
                return new PiscoPeruano($name, $quality, $sellIn);
            case 'Tumi de Oro Moche':
                return new Tumi($name, $quality, $sellIn);
            case 'Ticket VIP al concierto de Pick Floid':
                return new TicketsVIP($name, $quality, $sellIn);
            case 'Café Altocusco':
                return new Cafe($name, $quality, $sellIn);
            default:
                return new ProductoNormal($name, $quality, $sellIn);
        }
    }
}

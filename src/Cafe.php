<?php
namespace App;

use App\ProductoNormal;
use App\IProductoVillaPeruana;

class Cafe extends ProductoNormal implements IProductoVillaPeruana
{
    public function disminuirQuality(){
        if($this->sellIn <= 0) $this->quality = $this->quality - 4;
        else $this->quality = $this->quality - 2;
    }

    public function tick()
    {
        $this->disminuirQuality();
        $this->disminuirFechaVenta();
        $this->verificarReglasGenerales();
    }
}
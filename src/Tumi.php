<?php
namespace App;

use App\ProductoVillaPeruana;
use App\IProductoVillaPeruana;

class Tumi extends ProductoVillaPeruana implements IProductoVillaPeruana
{
    public function verificarReglasGenerales()
    {
        $this->quality = 80;
    }

    public function tick()
    {
        $this->verificarReglasGenerales();
    }
}
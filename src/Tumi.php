<?php
namespace App;

use App\ProductoNormal;
use App\IProductoVillaPeruana;

class Tumi extends ProductoNormal implements IProductoVillaPeruana
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
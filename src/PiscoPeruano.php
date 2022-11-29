<?php
namespace App;

use App\ProductoNormal;
use App\IProductoVillaPeruana;

class PiscoPeruano extends ProductoNormal implements IProductoVillaPeruana
{
    public function tick()
    {
        $this->aumentarQuality();
        $this->disminuirFechaVenta();
        $this->verificarReglasGenerales();
    }
}
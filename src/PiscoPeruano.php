<?php
namespace App;

use App\ProductoVillaPeruana;
use App\IProductoVillaPeruana;

class PiscoPeruano extends ProductoVillaPeruana implements IProductoVillaPeruana
{
    public function tick()
    {
        $this->aumentarQuality();
        $this->disminuirFechaVenta();
        $this->verificarReglasGenerales();
    }
}
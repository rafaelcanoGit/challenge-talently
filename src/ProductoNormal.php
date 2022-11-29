<?php
namespace App;

use App\ProductoVillaPeruana;
use App\IProductoVillaPeruana;

class ProductoNormal extends ProductoVillaPeruana implements IProductoVillaPeruana
{
    //IProductoVillaPeruana
    public function tick() {
        $this->disminuirQuality();
        $this->disminuirFechaVenta();
        $this->verificarReglasGenerales();
    }
}
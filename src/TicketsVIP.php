<?php
namespace App;

use App\ProductoNormal;
use App\IProductoVillaPeruana;

class TicketsVIP extends ProductoNormal implements IProductoVillaPeruana
{
    public function aumentarQuality()
    {
        if($this->sellIn > 10) return $this->quality = $this->quality + 1;
        if($this->sellIn > 5) return $this->quality = $this->quality + 2;
        if($this->sellIn > 0) return $this->quality = $this->quality + 3;
        return $this->quality = 0;
    }

    public function tick()
    {
        $this->aumentarQuality(); //Si es importante aumentar primero el quality para los tickets ya que trabaja evualuando el sellIn que llega, en pisco peruano No, siempre aumenta 1.
        $this->disminuirFechaVenta();
        $this->verificarReglasGenerales();
    }
}
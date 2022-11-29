<?php
namespace App;

use App\IProductoVillaPeruana;

class ProductoNormal implements IProductoVillaPeruana
{
    public $name;

    public $quality;

    public $sellIn;

    public function __construct($name, $quality, $sellIn)
    {
        $this->name = $name;
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getQuality()
    {
        return $this->quality;
    }

    public function getSellIn()
    {
        return $this->getSellIn;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setQuality($quality)
    {
        $this->quality = $quality;
    }

    public function setSellIn($sellIn)
    {
        $this->sellIn = $sellIn;
    }
    //IProductoVillaPeruana
    public function tick() {
        $this->disminuirQuality();
        $this->disminuirFechaVenta();
        $this->verificarReglasGenerales();
    }

    public function aumentarQuality()
    {
        $this->quality = $this->quality + 1;
    }

    public function disminuirFechaVenta()
    {
        $this->sellIn = $this->sellIn - 1;
    }

    public function disminuirQuality()
    {
        if($this->sellIn <= 0) $this->quality = $this->quality - 2;
        else $this->quality = $this->quality - 1;
    }

    public function verificarReglasGenerales()
    {
        if($this->quality < 0) $this->quality = 0;
        else if ($this->quality > 50) $this->quality = 50;
    }
}
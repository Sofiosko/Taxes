<?php

namespace BiteIT\Taxes;

class Price
{
    /** @var float */
    public $priceWithVat;

    /** @var float */
    public $priceWithoutVat;

    /** @var int */
    public $vatPercent;

    /** @var float */
    public $quantity = 1.0;

    /** @var Discount|null */
    public $discount = null;

    /** @var ICalcLogic */
    protected $calcLogic;

    /** @var float */
    protected $originalPriceWithVat;

    /** @var float */
    protected $originalPriceWithoutVat;

    /**
     * Price constructor.
     * @param ICalcLogic $compLogic
     * @param $vatPercent
     * @param null $priceWithVat
     * @param null $priceWithoutVat
     * @param float $quantity
     */
    public function __construct(ICalcLogic $compLogic, $vatPercent, $priceWithVat = null, $priceWithoutVat = null, $quantity = 1.0)
    {
        if (!isset($priceWithVat) && !isset($priceWithoutVat))
            throw new \InvalidArgumentException('Please specify at least one price');

        if(!$compLogic->validateVatPercent($vatPercent))
            throw new \InvalidArgumentException($vatPercent.' is not allowed vat rate');

        $this->priceWithoutVat = $priceWithoutVat;
        $this->priceWithVat = $priceWithVat;
        $this->vatPercent = $vatPercent;
        $this->quantity = $quantity;
        $this->calcLogic = $compLogic;

        $this->originalPriceWithoutVat = $priceWithoutVat;
        $this->originalPriceWithVat = $priceWithVat;
    }

    /**
     * @param ICalcLogic $compLogic
     * @param $vatPercent
     * @param $priceWithVat
     * @param float $quantity
     * @return Price
     */
    public static function createFromPriceWithVat(ICalcLogic $compLogic, $vatPercent, $priceWithVat, $quantity = 1.0)
    {
        return new static($compLogic, $vatPercent, $priceWithVat, null, $quantity);
    }

    /**
     * @param ICalcLogic $compLogic
     * @param $vatPercent
     * @param $priceWithoutVat
     * @param float $quantity
     * @return Price
     */
    public static function createFromPriceWithoutVat(ICalcLogic $compLogic, $vatPercent, $priceWithoutVat, $quantity = 1.0)
    {
        return new static($compLogic, $vatPercent, null, $priceWithoutVat, $quantity);
    }

    /**
     * @return float
     */
    public function getTotalPriceWithVat()
    {
        return $this->calcLogic->getTotalPriceWithVatFromPriceObject($this);
    }

    /**
     * @return float
     */
    public function getTotalPriceWithoutVat()
    {
        return $this->calcLogic->getTotalPriceWithoutVatFromPriceObject($this);
    }

    public function getTotalVat(){
        return $this->calcLogic->getTotalVatFromPriceObject($this);
    }

    /**
     * @return float
     */
    public function getUnitPriceWithVat()
    {
        if (!isset($this->priceWithVat)) {
            $this->priceWithVat = $this->calcLogic->getUnitPriceWithVatFromPriceObject($this);
            if(!isset($this->originalPriceWithVat))
                $this->originalPriceWithVat = $this->priceWithVat;
        }
        return $this->priceWithVat;
    }

    /**
     * @return float
     */
    public function getUnitPriceWithoutVat()
    {
        if (!isset($this->priceWithoutVat)) {
            $this->priceWithoutVat = $this->calcLogic->getUnitPriceWithoutVatFromPriceObject($this);
            if(!isset($this->originalPriceWithoutVat))
                $this->originalPriceWithoutVat = $this->priceWithoutVat;
        }
        return $this->priceWithoutVat;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return int
     */
    public function getVatPercent()
    {
        return $this->vatPercent;
    }

    /**
     * @return float
     */
    public function getVatCoefficient()
    {
        return $this->calcLogic->getVatCoefficient($this->getVatPercent());
    }

    /**
     * @return float
     */
    public function getVatRatio()
    {
        return static::calculateVatRatio($this->getVatPercent());
    }

    /**
     * @param $vatPercent
     * @return float
     */
    public static function calculateVatRatio($vatPercent)
    {
        return round((100 + $vatPercent) / 100, 4);
    }

    /**
     * @param $amount
     * @param bool $isOnVat
     * @return $this
     */
    public function setDiscount($amount, $isOnVat = true){
        if($isOnVat){
            $discountedPriceWithVat = $this->getUnitPriceWithVat() - $amount;
            $this->priceWithVat = $discountedPriceWithVat;
            $this->priceWithoutVat = null;
        } else {
            $discountedPriceWithoutVat = $this->getUnitPriceWithoutVat() - $amount;
            $this->priceWithoutVat = $discountedPriceWithoutVat;
            $this->priceWithVat = null;
        }
        return $this;
    }

    public function getOriginalPriceWithVat(){
        return $this->originalPriceWithVat;
    }

    public function getOriginalPriceWithoutVat(){
        return $this->originalPriceWithoutVat;
    }
}
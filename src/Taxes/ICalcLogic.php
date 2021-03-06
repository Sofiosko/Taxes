<?php

namespace BiteIT\Taxes;

/**
 * Class CalcLogic
 * @package BiteIT\Taxes
 */
interface ICalcLogic
{
    /**
     * Method for calculating price with vat from price without vat
     *
     * @param Price $price
     * @return float|int
     */
    public function getUnitPriceWithVatFromPriceObject(Price $price);

    /**
     * Method for calculating price without vat from price with vat
     *
     * @param Price $price
     * @return float
     */
    public function getUnitPriceWithoutVatFromPriceObject(Price $price);

    /**
     * Method for calculating total amount with vat from price object
     *
     * @param Price $price
     * @return float|int
     */
    public function getTotalPriceWithVatFromPriceObject(Price $price);

    /**
     * Method for calculating total amount without vat from price object
     *
     * @param Price $price
     * @return float|int
     */
    public function getTotalPriceWithoutVatFromPriceObject(Price $price);

    /**
     * Method for calculating array of totals with vat from prices array
     *
     * @param Price[] $prices
     * @return array
     */
    public function getTotalsWithVatFromPrices($prices);

    /**
     * Method for calculating array of totals without vat from prices array
     *
     * @param Price[] $prices
     * @return mixed
     */
    public function getTotalsWithoutVatFromPrices($prices);

    /**
     * Method for calculating amout of vat
     *
     * @param Price $price
     * @return mixed
     */
    public function getTotalVatFromPriceObject(Price $price);

    /**
     * Returns correctly rounded var coefficient
     *
     * @param $vatPercent
     * @return float
     */
    public function getVatCoefficient($vatPercent);

    /**
     * Returns false if passed percentage is not allowed
     *
     * @param $vatPercent
     * @return mixed
     */
    public function validateVatPercent($vatPercent);
}
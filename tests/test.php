<?php
require_once __DIR__ . '/../src/taxes.php';

/**
 * Whole calculation logic
 * -------------------------------------------
 */
$cl = new \BiteIT\Taxes\CalcLogic();


/**
 * Data
 * -------------------------------------------
 */
$pl = new \BiteIT\Taxes\PriceList(\BiteIT\Taxes\Rates::HIGH_PERCENT, $cl);

$pl->addWithVat(121, 1);
$pl->addWithVat(146.7, 2.5);

$pl->addWithVat(200, 2, \BiteIT\Taxes\Rates::MEDIUM_PERCENT);
$pl->addWithVat(223.3, 3, \BiteIT\Taxes\Rates::MEDIUM_PERCENT);

$pl->addWithVat(299, 4, \BiteIT\Taxes\Rates::LOW_PERCENT);
$pl->addWithVat(305.2, 4.5, \BiteIT\Taxes\Rates::LOW_PERCENT);


// adds item with negative price (discount for specific vat rate)
//$pl->addWithVat(-100, 1, \BiteIT\Taxes\Rates::HIGH_PERCENT);
// sets discount for all products proportionately
$pl->setDiscount(100, true);


/**
 * Example recap
 * -------------------------------------------
 */
$view = new \BiteIT\Taxes\View\TotalListRecap($pl);
$view->render();

echo '<pre>';
var_dump($pl);
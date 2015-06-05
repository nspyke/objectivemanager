<?php

use ReturnOnInvestmentCalculator as ROICalc;

class ReturnOnInvestmentCalculatorTest extends PHPUnit_Framework_TestCase
{

    public function testCalculateUnderPerformance()
    {
        $calc = new ReturnOnInvestmentCalculator(
            5, //number of employees
            10, //cost per employee
            10, //attrition rate %
            80, //fee earners %
            1 // size of HR dept
        );
        $expected = 0.1 * 5 * 10;
        $this->assertEquals($expected, $calc->calculateUnderPerformance());
    }

    public function testCalculateAttritionCost()
    {
        $calc = new ReturnOnInvestmentCalculator(
            5, //number of employees
            10, //cost per employee
            10, //attrition rate %
            80, //fee earners %
            1 // size of HR dept
        );
        $expected = 0.1 * 5 * 25000 * 0.17;
        $this->assertEquals($expected, $calc->calculateAttritionCost());
    }

    public function testCalculateWastedChargeableHours()
    {
        $calc = new ReturnOnInvestmentCalculator(
            5, //number of employees
            10, //cost per employee
            10, //attrition rate %
            80, //fee earners %
            1 // size of HR dept
        );
        $expected = (0.8 * 5) * 2 * 150;
        $this->assertEquals($expected, $calc->calculateWastedChargeableHours());
    }

    /**
     * @dataProvider numberOfEmployees
     */
    public function testCalculateAdminHours($numberOfEmployees, $expected)
    {
        $calc = new ReturnOnInvestmentCalculator(
            $numberOfEmployees, //number of employees
            10, //cost per employee
            10, //attrition rate %
            80, //fee earners %
            2 // size of HR dept
        );
        $this->assertEquals($expected, $calc->calculateAdminHours());
    }

    public function numberOfEmployees()
    {
        return [
            [250, 7800 * 2],
            [500, 7800 * 2],
            [750, (7800 * 2) + (15.6 * 250)]
        ];
    }

    public function testCalculateTotal()
    {
        $calc = new ReturnOnInvestmentCalculator(
            20, //number of employees
            10, //cost per employee
            10, //attrition rate %
            80, //fee earners %
            2 // size of HR dept
        );
        $expected = (0.1 * 20 * 10) +
            (0.1 * 20 * 25000 * 0.17) +
            ((0.8 * 20) * 2 * 150) +
            (7800 * 2);
        $this->assertEquals($expected, $calc->calculateTotal());
    }

    public function testCalculateReturnOnInvestment()
    {
        $calc = new ReturnOnInvestmentCalculator(
            20, //number of employees
            10, //cost per employee
            10, //attrition rate %
            80, //fee earners %
            2 // size of HR dept
        );
        $expected = (0.1 * 20 * 10) +
            (0.1 * 20 * 25000 * 0.17) +
            ((0.8 * 20) * 2 * 150) +
            (7800 * 2);
        $expected = $expected - 20000;
        $this->assertEquals($expected, $calc->calculateReturnOnInvestment());
    }


}

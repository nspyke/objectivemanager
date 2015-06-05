<?php


class ReturnOnInvestmentCalculator 
{
    const UNDER_PERFORMING_EMPLOYEES = 0.1;
    const ATTRITION_COSTS = 0.17;
    const AVERAGE_SALARY = 25000;
    const CHARGEABLE_HOURS = 150;
    const HR_COST_BELOW_500 = 7800;
    const EXTRA_HR_COST_ABOVE_500 = 15.6;
    const IMPLEMENTATION_COST = 20000;

    private $numberOfEmployees;
    private $costPerEmployee;
    private $attritionRate;
    private $feeEarners;
    private $sizeOfHRDepartment;

    /**
     * @param int $numberOfEmployees
     * @param float $costPerEmployee
     * @param float $attritionRate
     * @param float $feeEarners
     * @param int $sizeOfHRDepartment
     */
    public function __construct(
        $numberOfEmployees,
        $costPerEmployee,
        $attritionRate,
        $feeEarners,
        $sizeOfHRDepartment
    )
    {
        $this->numberOfEmployees = $numberOfEmployees;
        $this->costPerEmployee = $costPerEmployee;
        $this->attritionRate = $attritionRate / 100;
        $this->feeEarners = $feeEarners / 100;
        $this->sizeOfHRDepartment = $sizeOfHRDepartment;
    }

    /**
     * @return float
     */
    public function calculateUnderPerformance()
    {
        return (self::UNDER_PERFORMING_EMPLOYEES * $this->numberOfEmployees) * $this->costPerEmployee;
    }

    /**
     * @return float
     */
    public function calculateAttritionCost()
    {
        return ($this->attritionRate * $this->numberOfEmployees) * (self::AVERAGE_SALARY * self::ATTRITION_COSTS);
    }

    /**
     * @return float
     */
    public function calculateWastedChargeableHours()
    {
        return ($this->feeEarners * $this->numberOfEmployees) * 2 * self::CHARGEABLE_HOURS;
    }

    /**
     * @return float
     */
    public function calculateAdminHours()
    {
        if ($this->numberOfEmployees <= 500) {
            return self::HR_COST_BELOW_500 * $this->sizeOfHRDepartment;
        } else {
            $extraEmployees = $this->numberOfEmployees - 500;

            return (self::HR_COST_BELOW_500 * $this->sizeOfHRDepartment) + ($extraEmployees * self::EXTRA_HR_COST_ABOVE_500);
        }
    }

    /**
     * @return float
     */
    public function calculateTotal()
    {
        return (
            $this->calculateUnderPerformance() +
            $this->calculateAttritionCost() +
            $this->calculateWastedChargeableHours() +
            $this->calculateAdminHours()
        );
    }

    /**
     * @return float
     */
    public function calculateReturnOnInvestment()
    {
        return $this->calculateTotal() - self::IMPLEMENTATION_COST;
    }
}

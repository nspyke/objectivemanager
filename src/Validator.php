<?php


class Validator 
{
    private $values;

    function __construct($values)
    {
        $this->values = $values;
    }

    public function isValid()
    {
        // normally you'd validate all values here
        // but for the sake of simplicity of this sample
        // we only check for a value

        foreach ($this->values as $val) {
            if (empty($val)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->values;
    }


}
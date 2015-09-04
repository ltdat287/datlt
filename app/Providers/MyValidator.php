<?php namespace App\Providers;

use Illuminate\Validation\Validator;

class MyValidator extends Validator {

	/**
	 * [validateBossWithEmployee description]
	 * @param  [type] $attribute  [description]
	 * @param  [type] $value      [description]
	 * @param  [type] $parameters [description]
	 * @return [type]             [description]
	 */
    public function validateBossWithEmployee($attribute, $value, $parameters)
    {
        return ($this->getValue($parameters[0]) != 'employee') ? false : true;
    }

    public function validateStartToEndDate($attribute, $value, $parameters)
    {
    	if ($this->getValue($parameters[0]) <= $value)
    	{

    		return true;
    	} else {

    		return false;
    	}
    }

}
<?php namespace App\Providers;

use Illuminate\Validation\Validator;
use App\User;
use Symfony\Component\Translation\TranslatorInterface;
use Carbon\Carbon;
use App\Helpers\MemberHelper;

class MyValidator extends Validator {
    /**
     * Set validate rule for set boss_id only with employee
     * @param  strin $attribute
     * @param  numeric $value
     * @param  string $parameters
     * @return boolean
     */
    public function validateBossWithEmployee($attribute, $value, $parameters)
    {
        $result = ($value != 0 && $this->getValue($parameters[0]) != EMPLOYEE) ? false : true;

        return $result;
    }

    /**
     * Set Start date only less than to End date
     * @param  string $attribute
     * @param  date $value      Value of end_date
     * @param  date $parameters Value of start_date
     * @return boolean
     */
    public function validateStartToEndDate($attribute, $value, $parameters)
    {
    	if ($this->getValue($parameters[0]) <= $value)
    	{

    		return true;
    	} else {

    		return false;
    	}
    }

    /**
     * Set validate rule for change employee to boss if had boss_id will failed
     * @param  string $attribute
     * @param  string $value      value of use_role
     * @param  numeric $parameters value of boss_id
     * @return boolean
     */
    public function validateEmployeeToBoss($attribute, $value, $parameters)
    {
        if ($this->getValue($parameters[0]) != 0 && $value == BOSS)
        {

            return false;
        } else {

            return true;
        }
    }

    /**
     * Set validate rule for change boss to employee if boss has not member
     * @param  string $attribute
     * @param  string $value      value of use_role
     * @param  numeric $parameters id 0f number
     * @return boolean
     */
    public function validateBossToEmployee($attribute, $value, $parameters)
    {
        $id = $parameters[0];
        $user = User::find($id);

        if ($user->role == BOSS && $value == EMPLOYEE)
        {
            $has_employee = User::where('boss_id', $id)->firstOrFail();
            if ($has_employee) {

                return false;
            }
        } else {

            return true;
        }
    }

    /**
     * Function for custom validation vpdate.
     *
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return boolean
     */
    public function validateVpDate($attribute, $value, $parameters)
    {
        // Parse current value to time
        $curDate = Carbon::createFromFormat(VP_TIME_FORMAT, $value);

        // Get min date
        $minDate = Carbon::createFromFormat(VP_TIME_FORMAT, VP_DATE_MIN);

        // Get max date
        $maxDate = Carbon::createFromFormat(VP_TIME_FORMAT, MemberHelper::getMaxDate());
        if ($minDate < $curDate && $curDate < $maxDate)
        {
            return true;
        }

        return false;
    }

    /**
     * Function for custom validation vptelephone.
     *
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return boolean
     */
    public function validateVpTelephone($attribute, $value, $parameters)
    {
        if ("regex:/0(?:\d\-\d{4}|\d{2}\-\d{3}|\d{3}\-\d{2}|\d{4}\-\d{1})\-\d{4}$/") {
            return true;
        }

        return false;
    }
    /**
     * Function for custom validation vpemail.
     *
     * @param string $attribute
     * @param string $value
     * @param array $parameters
     * @return boolean
     */
    public function validateVpEmail($attribute, $value, $parameters)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) || preg_match('/^[a-z0-9]+@localhost$/', $value))
        {
            return true;
        }

        return false;
    }

    /**
     * Function for custom validate for email_confirmation need same email
     * @param  string $attribute
     * @param  string $value
     * @param  string $parameters value of fields email
     * @return boolean
     */
    public function validateVpSame($attribute, $value, $parameters)
    {
        if (!empty($this->getValue($parameters[0])) && $value !== $this->getValue($parameters[0]))
        {
            return false;
        }

        return true;
    }
}
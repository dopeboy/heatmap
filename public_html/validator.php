<?php

abstract class Validator
{
    static function isNotNullAndNotEmpty ($parameter_value,$parameter_name) 
    {
        if (is_array($parameter_value) && count($parameter_value) == 0)
            throw new RequiredParameterMissingException($parameter_name);    
            
        else if ($parameter_value == null || $parameter_value == '') 
            throw new NoAPIKeySpecified();       
    }

    static function isValidDropdownValue ($parameter_value,$parameter_name)
    {
        if($parameter_value == -1)
            throw new RequiredParameterMissingException($parameter_name);
    }

    static function isValidZipcode ($parameter_value,$parameter_name) 
    {
        if(strlen($parameter_value) !=5 || !ctype_digit($parameter_value))
            throw new InvalidZipcodeException();
    }        

    static function isValidDate ($parameter_value,$parameter_name) 
    {
        $format = 'mm/dd/yyyy';

        if(strlen($parameter_value) >= 6 && strlen($format) == 10){ 

            // find separator. Remove all other characters from $format 
            $separator_only = str_replace(array('m','d','y'),'', $format); 
            $separator = $separator_only[0]; // separator is first character 

            if($separator && strlen($separator_only) == 2){ 
                // make regex 
                $regexp = str_replace('mm', '(0?[1-9]|1[0-2])', $format); 
                $regexp = str_replace('dd', '(0?[1-9]|[1-2][0-9]|3[0-1])', $regexp); 
                $regexp = str_replace('yyyy', '(19|20)?[0-9][0-9]', $regexp); 
                $regexp = str_replace($separator, "\\" . $separator, $regexp); 
               
                if($regexp != $parameter_value && preg_match('/'.$regexp.'\z/', $parameter_value)){ 

                    // check date 
                    $arr=explode($separator,$parameter_value); 
                    $day=$arr[1]; 
                    $month=$arr[0]; 
                    $year=$arr[2]; 

                    if(@checkdate($month, $day, $year)) 
                        return $parameter_value; 
                } 
            } 
        } 

        throw new InvalidDateException();
    }

    static function isValidEmailAddress ($parameter_value,$parameter_name) 
    {
        if(!filter_var($parameter_value, FILTER_VALIDATE_EMAIL) || !preg_match('/@.+\./', $parameter_value))
            throw new InvalidEmailException();
    }       

    static function isValidName ($parameter_value,$parameter_name) 
    {
        if(preg_match('/[A-Za-z]/', $parameter_value) == 0 || strlen($parameter_value) <= 1 || strlen($parameter_value) >= 15)
            throw new InvalidNameException($parameter_name);
    }    
    
    static function isValidPassword ($parameter_value,$parameter_name) 
    {
        if(strlen($parameter_value) < 3)
            throw new InvalidPassword();
    }     
    
    static function isValidURLFormat ($parameter_value,$parameter_name) 
    {
        if(!filter_var($parameter_value, FILTER_VALIDATE_URL))
            throw new InvalidURLFormatException();
    }        
}

?>

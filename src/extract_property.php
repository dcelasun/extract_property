<?php
/**
 * This file is part of the extract_property library
 *
 * For the full license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */

if (!function_exists('extract_property')) {

    /**
     * Returns the values from a single property of the objects 
     * in the $objects array, identified by the $key.
     *
     * @param array $objects An array of objects. Only objects with a property $key will be used.
     * @param mixed $key     The property to be looked for.
     * @param mixed $index   If specified, this will be used as the keys of the result array.
     *
     * @return array  
     * 
     */
    function extract_property($objects = array(), $key = null, $index = null)
    {
        $args = func_get_args();
        
        if (!array_key_exists(0, $args))
        {
            trigger_error('extract_property() expects at least 2 parameters, 0 given', E_USER_WARNING);
            return null;
        }
        elseif (!array_key_exists(1, $args))
        {
            trigger_error('extract_property() expects at least 2 parameters, 1 given', E_USER_WARNING);
            return null;
        }
        
        if ((array)$args[0] !== $args[0])
        {
            trigger_error('extract_property() expects parameter 1 to be array, '.gettype($args[0]).' given', E_USER_WARNING);
            return null;
        }

        if ( !is_int($args[1])    &&
             !is_float($args[1])  &&
             !is_string($args[1]) &&
             $args[1] !== null    &&
             !(is_object($args[1]) && method_exists($args[1], '__toString')))
        {
            trigger_error('extract_property(): The key should be either a string or an integer', E_USER_WARNING);
            return null;
        }

        if ( isset($args[2])      && 
             !is_int($args[2])    &&
             !is_float($args[2])  &&
             !is_string($args[2]) &&
             !(is_object($args[2]) && method_exists($args[2], '__toString')))
        {
            trigger_error('extract_property(): The index should be either a string or an integer', E_USER_WARNING);
            return null;
        }
        
        $paramsInput = $args[0];
        $paramsKey   = $args[1];
        
        $paramsIndex = null;
        
        if (isset($args[2]))
        {
            if (is_float($args[2]) || is_int($args[2]))
            {
                $paramsIndex = (int)$args[2];
            }
            else
            {
                $paramsIndex = (string)$args[2];
            }
        }
        
        $result = array();
        
        foreach ($paramsInput as $item)
        {
            if (isset($item->$paramsKey))
            {
                if (!is_null($paramsIndex) && isset($item->$paramsIndex))
                {
                    $result[$item->$paramsIndex] = $item->$paramsKey;
                }
                else
                {
                    $result[] = $item->$paramsKey;
                }
            }
        }
        
        return $result;
    }

}

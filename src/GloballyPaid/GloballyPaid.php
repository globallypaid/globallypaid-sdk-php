<?php 
/**
 * Copyright © 2022 Global Payroll Gateway, Inc
 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the “Software”), to deal in the
 * Software without restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the
 * Software, and to permit persons to whom the Software is furnished to do so, subject
 * to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
 * CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE
 * OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @license MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 * 
 * @property-read GloballyPaid\Resources\PaymentResource $payment Payment resources
 * @property-read GloballyPaid\Resources\CustomerResource $customer Customer resources
 * @property-read GloballyPaid\Resources\TokenResource $token Token resources
 * @property-read GloballyPaid\Resources\PaymentInstrumentResource $payment_instrument PaymentInstrument resources
 */
namespace GloballyPaid;

class GloballyPaid
{
    

    private static $_availableResources = ['payment', 'customer', 'token', 'payment_instrument'];
    
    private static $_resources = [];
    
    private $_config = [];
    
    function __construct($config) 
    {
        $this->_config = $config;
    }

    /**
     * Load API resources dynamically and lazy load them as needed
     * @param string $resource The name of the resource to load
     */
    public function __get($resource)
    {
        $resource = strtolower($resource);
        if (in_array($resource, static::$_availableResources)) {
            $class = $this->get_class_name($resource);
            if (!$this->__isset($resource)) {
                $ref = new \ReflectionClass('GloballyPaid\\Resources\\' . $class);
                $obj = $ref->newInstanceArgs([$this->_config]);
                static::$_resources[$resource] = $obj;
            }
            return static::$_resources[$resource];
        }
    }

    /**
     * Check that a resource has been loaded and is ready to use
     * @param string $resource
     */
    public function __isset($resource)
    {
        $resource = strtolower($resource);
        return in_array($resource, static::$_availableResources) &&
            isset(static::$_resources[$resource]) &&
            static::$_resources[$resource] instanceof Resources\Resource;
    }


    /**
     * Get's the classname from a resource
     * @param string $resource
     * @return string The title case class name
     */
    private function get_class_name($resource)
    {
        $className = ucfirst(strtolower($resource));
        if (stripos($className, '_') !== false) {
            $className = $className . ucfirst(explode('_', $className)[1]);
        }
        return $className . 'Resource';
    }


}
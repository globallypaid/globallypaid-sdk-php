<?php 
/**
 * @license https://globallypaid.mit-license.org/ MIT
 * @copyright 2022 Global Payroll Gateway, Inc
 * @filesource
 */
namespace GloballyPaid;

/**
 * GloballyPaid PHP-SDK
 * 
 * @property-read Resources\PaymentResource $payment Payments API
 * @property-read Resources\CustomerResource $customer Customer API
 * @property-read Resources\TokenResource $token Token API
 * @property-read Resources\PaymentInstrumentResource $payment_instrument PaymentInstrument API
 */
class GloballyPaid
{
    

    private static $_availableResources = ['payment', 'customer', 'token', 'payment_instrument'];
    
    private static $_resources = [];
    
    private $_config = [];
    
    function __construct($config = []) 
    {
        $this->_config = $config;
    }

    /**
     * Load API resources dynamically and lazy load them as needed
     * @param string $resource The resource name: [payment|customer|token|payment_instrument]
     */
    public function __get($resource)
    {
        $resource = strtolower($resource);
        if (in_array($resource, static::$_availableResources)) {
            
            if (!$this->__isset($resource)) {
                $this->load_resource($resource);
            }
            
            return static::$_resources[$resource];
        }
    }

    /**
     * Check that a resource has been loaded and is ready to use
     * @param string $resource The resource name: [payment|customer|token|payment_instrument]
     */
    public function __isset($resource)
    {
        $resource = strtolower($resource);
        return in_array($resource, static::$_availableResources) &&
            isset(static::$_resources[$resource]) &&
            static::$_resources[$resource] instanceof Resources\Resource;
    }
    
    /**
     * Unset/remove a resource from the resource map
     * @param string $resource The resource name: [payment|customer|token|payment_instrument]
     */
    public function __unset($resource)
    {
        if ($this->__isset($resource)) {
            unset(static::$_resources[strtolower($resource)]);
        }
    }
    
    /**
     * Set the config dynamically. Note that calling this will "reset" all the actively
     * loaded resources to use the configuration 
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->_config = $config;
        if (!empty(static::$_resources)) {
            foreach(static::$_resources as $resource => $instance) {
                $this->__unset($resource);
                $this->load_resource($resource);
            }
        }
    }
    
    /**
     * Loads a resource into the resource map for use
     * @param string $resource The resource name: [payment|customer|token|payment_instrument]
     */
    private function load_resource($resource)
    {
        $class = $this->get_class_name(strtolower($resource));
        $ref = new \ReflectionClass('GloballyPaid\\Resources\\' . $class);
        $obj = $ref->newInstanceArgs([$this->_config]);
        static::$_resources[$resource] = $obj;
        
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
<?php
/**
 * Setup all hooks and required classes
 *
 * PHP Version 7.0
 *
 * @author CODE TOT JSC <dev@codetot.com>
 * @since 0.0.1
 * @package CT_Example_Class
 */

/**
 * Init class
 */
class CT_Example_Class
{
    /**
     * Singleton instance
     *
     * @var CT_Example_Class
     */
    private static $instance;

    /**
   * Get singleton instance.
   *
   * @return CT_Example_Class
   */
    final public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Construct
     */
    public function __construct()
    {
    }
}

CT_Example_Class::instance();

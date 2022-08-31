<?php
/**
 * @package email-landing-plugin
 *
 */

namespace Inc;

final class Init
{
    /**
     * Store all the classes inside an array
     * @return array of classes
     */
    public static function get_services()
    {
        return [
            Base\Settings::class,
            Base\Enqueue::class,
            Base\SettingsLink::class,
            Base\VideoShortcode::class,
            Base\LogoShortcode::class,
            Base\CalendlyShortcode::class
        ];
    }

    /**
     * Loop through all the classes and initialize them
     */
    public static function register_services()
    {
        foreach (self::get_services() as $class) {
            $service = self::instantiate($class);
            if (method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    /**
     * Initialize the class
     */
    private static function instantiate ($class)
    {
        $service = new $class();

        return new $service;
    }
}
<?php

namespace Galahad\LaravelAddressing;

use Galahad\LaravelAddressing\Validator\AdministrativeAreaValidator;
use Galahad\LaravelAddressing\Validator\CountryValidator;
use Galahad\LaravelAddressing\Validator\PostalCodeValidator;
use Illuminate\Support\Facades\Validator;

/**
 * Class ServiceProvider
 *
 * @package Galahad\LaravelAddressing
 * @author Chris Morrell
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Booting the Service Provider
     */
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require_once __DIR__ . '/routes.php';
        }
        $this->registerValidators();
    }

    /**
     * Register the LaravelAddressing instance
     */
    public function register()
    {
        $this->app->singleton(LaravelAddressing::class, function ($app) {
            return LaravelAddressing::getInstance();
        });
    }

    /**
     * Register all custom validators
     */
    protected function registerValidators()
    {
        // Country validators
        $this->app->validator->resolver(function ($translator, $data, $rules, $messages = [], $attributes = []) {
            return new CountryValidator($translator, $data, $rules, $messages, $attributes);
        });

        // AdministrativeArea validators
        $this->app->validator->resolver(function ($translator, $data, $rules, $messages = [], $attributes = []) {
            return new AdministrativeAreaValidator($translator, $data, $rules, $messages, $attributes);
        });

        // PostalCode validator
        $this->app->validator->resolver(function ($translator, $data, $rules, $messages = [], $attributes = []) {
            return new PostalCodeValidator($translator, $data, $rules, $messages, $attributes);
        });
    }
}

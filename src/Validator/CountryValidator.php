<?php

namespace Galahad\LaravelAddressing\Validator;

use CommerceGuys\Intl\Exception\UnknownCountryException;
use Exception;
use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Validation\Validator;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class CountryValidator
 *
 * @package Galahad\LaravelAddressing\Validator
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class CountryValidator
{
    /**
     * The validator messages
     *
     * @var array
     */
    protected $messages = [
        'country_name' => 'The :attribute has not a valid country name.',
        'country_code' => 'The :attribute has not a valid country code.',
    ];

    /**
     * @var LaravelAddressing
     */
    protected $addressing;

    /**
     * The constructor method
     *
     * @param LaravelAddressing $addressing
     */
    public function __construct(LaravelAddressing $addressing) {
        $this->addressing = $addressing;
    }

    /**
     * Validate a country by its name
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @param Validator $validator
     * @return bool
     */
    public function validateCountryName($attribute, $value, array $parameters, Validator $validator)
    {
        $validator->setCustomMessages($this->messages);
        try {
            $country = $this->addressing->countryByName($value);
            return $country instanceof Country;
        } catch (UnknownCountryException $exception) {
            return false;
        }
    }

    /**
     * Validate a country by its code
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @param Validator $validator
     * @return bool
     */
    public function validateCountryCode($attribute, $value, array $parameters, Validator $validator)
    {
        $validator->setCustomMessages($this->messages);
        try {
            $country = $this->addressing->country($value);
            return $country instanceof Country;
        } catch (UnknownCountryException $exception) {
            return false;
        }
    }

    /**
     * @return LaravelAddressing
     */
    public function getAddressing()
    {
        return $this->addressing;
    }

    /**
     * @param LaravelAddressing $addressing
     */
    public function setAddressing(LaravelAddressing $addressing)
    {
        $this->addressing = $addressing;
    }
}

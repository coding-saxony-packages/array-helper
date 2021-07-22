<?php

namespace CodingSaxony\ArrayHelper;

/**
 * Class UndotHelper
 *
 * @package CodingSaxony\ArrayHelper
 */
class UndotHelper
{
    /**
     * Expands a dot notation array into a full multi-dimensional array.
     *
     * @param array $dotNotationArray
     *
     * @return array
     */
    public static function undot(array $dotNotationArray): array
    {
        $array = [];

        foreach ($dotNotationArray as $key => $value) {
            self::set($array, $key, $value);
        }

        return $array;
    }

    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param array  $array
     * @param string $key
     * @param mixed  $value
     *
     * @return array
     */
    private static function set(array &$array, string $key, mixed $value): array
    {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);
            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }
}
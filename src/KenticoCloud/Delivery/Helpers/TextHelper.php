<?php

namespace KenticoCloud\Delivery\Helpers;

class TextHelper extends Singleton
{    
    //http://syframework.alwaysdata.net/decamelize
    function decamelize($input, $separator = '_')
    {
        //TODO: dangerous! there might be more than one underscore!
        return strtolower(preg_replace(array('/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'), '$1'. $separator .'$2', $input));
    }

    //http://stackoverflow.com/a/33122760/3363709
    function pascalCase($input, $separator = '_')
    {
        return str_replace($separator, '', ucwords($input, $separator));
    }

    function camelCase($input, $separator = '_')
    {
        return str_replace($separator, '', lcfirst(ucwords($input, $separator)));
    }
}

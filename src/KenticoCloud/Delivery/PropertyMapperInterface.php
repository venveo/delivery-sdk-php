<?php

namespace KenticoCloud\Delivery;

interface PropertyMapperInterface
{
    public function getProperty($data, $modelType, $property);
}
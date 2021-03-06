<?php
namespace KenticoCloud\Delivery\Models\Types;
use \KenticoCloud\Delivery\Models;

/**
 * MultipleOptionsTypeElement
 *
 * Represents content type element with possibility to select from multiple
 * choices.
 */
class MultipleOptionsTypeElement extends Models\ContentTypeElement
{
    public $options = null;

    public function __construct($type, $codename, $name, $options)
    {
        $this->options = $options;
        parent::__construct($type, $codename, $name);
    }
}
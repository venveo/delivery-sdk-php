<?php

namespace KenticoCloud\Delivery\Models;

use \KenticoCloud\Delivery\ModelBinder;

class ContentItems
{
    public $items = null;
    public $pagination = null;

    public function __construct(ModelBinder $modelBinder, $obj)
    {
        $this->populate($modelBinder, $obj);
        return $this;
    }

    protected function populate($modelBinder, $obj)
    {
        $properties = get_object_vars($obj);
        
        // Items
        $this->items = $modelBinder->getContentItems($properties['items'], $properties['modular_content']);

        // Pagination
        $this->pagination = $modelBinder->bindModel(Pagination::class, $properties['pagination']);

        return $this;
    }
}

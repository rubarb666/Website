<?php
namespace Rhubarb\Website\Leaves;

use Rhubarb\Leaf\Leaves\Leaf;
use Rhubarb\Website\Models\Comment;

class DefaultLeaf extends Leaf
{
    /**
    * @var DefaultLeafModel
    */
    protected $model;

    protected function getViewClass()
    {
        return DefaultLeafView::class;
    }

    protected function createModel()
    {
        $model = new DefaultLeafModel();

        // If your model has events you want to listen to you should attach the handlers here
        // e.g.
        // $model->selectedUserChangedEvent->attachListener(function(){ ... });

        return $model;
    }
}
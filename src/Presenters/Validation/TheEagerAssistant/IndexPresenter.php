<?php

namespace Rhubarb\Website\Presenters\Validation\TheEagerAssistant;

use Rhubarb\Leaf\Presenters\Forms\Form;

class IndexPresenter extends Form
{
    /**
     * Called to create and register the view.
     *
     * The view should be created and registered using RegisterView()
     * Note that this will not be called if a previous view has been registered.
     *
     * @see Presenter::registerView()
     */
    protected function createView()
    {
        return new IndexView();
    }

}
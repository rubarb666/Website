<?php

namespace Rhubarb\Website\Presenters\Validation\TheEagerAssistant;

use Rhubarb\Leaf\Views\HtmlView;
use Rhubarb\Leaf\Views\WithViewBridgeTrait;
use Rhubarb\Website\Presenters\Validation\TestFormLayout;

class IndexView extends HtmlView
{
    use WithViewBridgeTrait;
    use TestFormLayout;


    /**
     * Implement this and return __DIR__ when your ViewBridge.js is in the same folder as your class
     *
     * @returns string Path to your ViewBridge.js file
     */
    public function getDeploymentPackageDirectory()
    {
        return __DIR__;
    }


    public function getDeploymentPackage()
    {
        $package = parent::getDeploymentPackage();
        $package->resourcesToDeploy[] = VENDOR_DIR."/rhubarbphp/module-jsvalidation/src/validation.js";
        $package->resourcesToDeploy[] = $this->getDeploymentPackageDirectory() . "/" . $this->getClientSideViewBridgeName() . ".js";

        return $package;
    }

    protected function printViewContent()
    {
        $this->printForm();
    }
}
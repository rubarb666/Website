<?php

namespace Rhubarb\Website;

use Monolog\Handler\ChromePHPHandler;
use Monolog\Logger;
use Rhubarb\Crown\Application;
use Rhubarb\Crown\Logging\Log;
use Rhubarb\Crown\Logging\MonologLog;
use Rhubarb\Stem\StemSettings;
use Rhubarb\Website\Settings\WebsiteSettings;

$dbSettings = StemSettings::singleton();
$dbSettings->host = "127.0.0.1";
$dbSettings->username = "root";
$dbSettings->password = "";
$dbSettings->database = "vagrant";

Application::current()->developerMode = true;

$logger = new Logger("rhubarb");
$logger->pushHandler( new ChromePHPHandler() );

$googleSecret = new WebsiteSettings();
$googleSecret->SettingName = "GoogleSecret";
$googleSecret->SettingValue = "6LeWkyQTAAAAAIgDmiULMGbGiWOZtmfXLBORXwdu";
$googleSecret->save();

Log::AttachLog( new MonologLog(Log::ALL, $logger) );
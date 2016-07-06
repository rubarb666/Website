<?php

namespace Rhubarb\Website;

use Monolog\Handler\ChromePHPHandler;
use Monolog\Logger;
use Rhubarb\Crown\Application;
use Rhubarb\Crown\Logging\Log;
use Rhubarb\Crown\Logging\MonologLog;
use Rhubarb\Stem\StemSettings;

$dbSettings = StemSettings::singleton();
$dbSettings->host = "127.0.0.1";
$dbSettings->username = "root";
$dbSettings->password = "";
$dbSettings->database = "vagrant";

Application::current()->developerMode = true;

$logger = new Logger("rhubarb");
$logger->pushHandler( new ChromePHPHandler() );

Log::AttachLog( new MonologLog(Log::ALL, $logger) );
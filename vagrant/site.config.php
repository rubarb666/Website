<?php

namespace Gcd\Hub;

use Gcd\Core\Context;
use Gcd\Core\Logging\Log;
use Gcd\Core\Logging\PhpLog;
use Gcd\Core\Modelling\ModellingSettings;

$dbSettings = new ModellingSettings();
$dbSettings->Host = "127.0.0.1";
$dbSettings->Username = "root";
$dbSettings->Password = "";
$dbSettings->Database = "gcdhub";

$context = new Context();
$context->DeveloperMode = true;

Log::AttachLog( new PhpLog( Log::ALL ) );
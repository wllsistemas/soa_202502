<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

require_once './core/Http.php';
require_once './core/Routes.php';
require_once './core/Core.php';

Core::dispatch(Http::routes());

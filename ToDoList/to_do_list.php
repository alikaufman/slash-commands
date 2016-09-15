<?php

require_once "CommandHandler.php";
require_once "TaskManager.php";

$command = $_POST['command'];
$domain = $_POST['text'];
$token = $_POST['token'];

$taskManager = new TaskManager();
$commandHandler = new CommandHandler($taskManager);

$response = $commandHandler->handleCommand($token, $command, $domain);

echo $response;

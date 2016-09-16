<?php

require_once "CommandHandler.php";
require_once "TaskManager.php";
require_once "config.php";

$command = $_POST['command'];
$domain = $_POST['text'];
$token = $_POST['token'];

$taskManager = new TaskManager($host, $mySqlUsername, $mySqlPassword);
$commandHandler = new CommandHandler($taskManager);

$commandHandler->handleCommand($token, $command, $domain);

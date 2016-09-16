<?php

require_once "CommandHandler.php";
require_once "TaskManager.php";
require_once "config.php";

$command = $_POST['command'];
$text = $_POST['text'];
$token = $_POST['token'];

$taskManager = new TaskManager($host, $mySqlUsername, $mySqlPassword);
$commandHandler = new CommandHandler($taskManager, $tokens);

$commandHandler->handleCommand($token, $command, $text);

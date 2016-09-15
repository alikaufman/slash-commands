<?php

class CommandHandler
{
    const SLACK_TOKEN = '7DDbqpU6FtNv7FmvhpdH5r3V';

    const COMMAND_ADD_TASK = '/addtask';
    
    private $taskManager;

    public function __construct(TaskManager $taskManager)
    {
        $this->taskManager = $taskManager;
    }

    public function handleCommand($token, $command, $text)
    {
        $this->validateToken($token);

        if ($command === self::COMMAND_ADD_TASK) {
            $newTask = $this->taskManager->addTask($text);
            return "ADDED\n " . $newTask->__toString();
        }
    }

    /**
     * @param string $token
     */
    private function validateToken($token)
    {
        if ($token !== self::SLACK_TOKEN) {
            die("Token does not match");
        }
    }
}

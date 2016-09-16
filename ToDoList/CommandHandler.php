<?php

class CommandHandler
{
    const COMMAND_ADD = '/addtask';
    const COMMAND_SHOW_ALL = '/tasks';
    const COMMAND_FIND_BY_NAME = '/findtask';

    /** @var TaskManager  */
    private $taskManager;

    /** @var  array */
    private $tokens;
    
    public function __construct(TaskManager $taskManager, $tokens)
    {
        $this->taskManager = $taskManager;
        $this->tokens = $tokens;
    }

    public function handleCommand($token, $command, $text)
    {
        $this->validateToken($token);
        
        switch ($command) {
            case self::COMMAND_ADD:
                if ($this->taskManager->addTask($text))
                    echo "Added new task [$text]";
                else {
                    echo "Task not added";
                }
                break;
            case self::COMMAND_SHOW_ALL:
                $this->echoAllTasks($this->taskManager->showAll());
                break;
            case self::COMMAND_FIND_BY_NAME:
                $this->echoTasksByName($this->taskManager->getTaskByName($text));
                break;
            default:
                echo 'There was an error :(';
        }
    }

    /**
     * @param array $rows
     */
    private function echoAllTasks(array $rows)
    {
        if ($rows) {
            foreach ($rows as $row) {
                echo sprintf("%d. %s\n",
                    $row[0],
                    $row[1]
                );
            }
        } else {
            echo 'None found';
        }
    }

    /**
     * @param array $rows
     */
    private function echoTasksByName(array $rows)
    {
        if ($rows) {
            foreach ($rows as $row) {
                echo sprintf("%s\n[ID] %s\n[Created] %s\n [Due] %s\n[Status] %s\n[Description] %s\n",
                    strtoupper($row['name']),
                    $row['id'],
                    $row['createdAt'],
                    $row['dueDate'] ?: '--',
                    $row['status'],
                    $row['description'] ?: '--'
                );
            }
        } else {
            echo 'None found';
        }
    }
    
    /**
     * @param string $token
     */
    private function validateToken($token)
    {
        if (!in_array($token, $this->tokens)) {
            die("Token does not match");
        }
    }
}

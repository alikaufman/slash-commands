<?php

class CommandHandler
{
    const COMMAND_ADD = '/addtask';
    const COMMAND_SHOW_ALL = '/tasks';
    const COMMAND_FIND_BY_NAME = '/findtask';

    /** @var TaskManager  */
    private $taskManager;

    static $tokens = [
        '7DDbqpU6FtNv7FmvhpdH5r3V',
        'pTKUaEv3nOgPAxrpj5FHEgiw',
        'kmTu4bSi8AaKlSYPklnkCw7K',
    ];

    public function __construct(TaskManager $taskManager)
    {
        $this->taskManager = $taskManager;
    }

    public function handleCommand($token, $command, $text)
    {
        $this->validateToken($token);
        
        switch ($command) {
            case self::COMMAND_ADD:
                echo $this->taskManager->addTask($text);
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
                echo $row[0] . "\n";
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
        if (!in_array($token, self::$tokens)) {
            die("Token does not match");
        }
    }
}

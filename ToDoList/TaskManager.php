<?php


class TaskManager
{
    const DATABASE = 'task_bot';

    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in progress';
    const STATUS_COMPLETED = 'completed';
    
    /** @var  string */
    private $host;

    /** @var  string */
    private $sqlUsername;

    /** @var  string */
    private $sqlPassword;

    public function __construct($host, $sqlUsername, $sqlPassword)
    {
        $this->host = $host;
        $this->sqlUsername = $sqlUsername;
        $this->sqlPassword = $sqlPassword;
    }

    /**
     * @param $name
     * @return string
     */
    public function addTask($name)
    {
        $dbConnection = $this->getSQLConnection();

        $name = $dbConnection->real_escape_string($name);
        $status = self::STATUS_NEW;
        
        $statement = $dbConnection->prepare($this->getInsertQuery());
        $statement->bind_param('ss', $name, $status);
        $statement->execute();
        $statement->close();

        return $statement ? "Created new task '$name'" : "Uh, oh, something went wrong";
    }

    /**
     * @return array
     */
    public function showAll()
    {
        $dbConnection = $this->getSQLConnection();

        $statement = $dbConnection->query($this->getFindAllQuery());

        $rows = [];
        
        while ($row = $statement->fetch_row()) {
            $rows[] = $row;
        }

        $statement->close();

        return $rows;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getTaskByName($name)
    {
        $dbConnection = $this->getSQLConnection();
        
        $statement = $dbConnection->prepare($this->getFindByNameQuery());
        $statement->bind_param('s', $name);
        $statement->execute();
        $statement->bind_result($id, $name, $createdAt, $dueDate, $status, $description);
        
        $rows = [];
        while ($statement->fetch()) {
            $rows[] = [
                'id' => $id,
                'name' => $name,
                'createdAt' => $createdAt,
                'dueDate' => $dueDate,
                'status' => $status,
                'description' => $description,
            ];
        }

        $statement->close();
        
        return $rows;
    }

    /**
     * @return string
     */
    private function getFindByNameQuery()
    {
        return <<<SQL
SELECT id,
name,
date_format(createdAt, '%a, %b %d, %Y') as createdAt,
date_format(dueDate, '%a, %b %d, %Y') as dueDate,
status,
description
FROM tasks
WHERE name = ?
SQL;
    }

    /**
     * @return string
     */
    private function getFindAllQuery()
    {
        return <<<SQL
SELECT name
FROM tasks
SQL;
    }
    
    private function getInsertQuery()
    {
        return <<<SQL
INSERT INTO tasks (name, status) 
VALUES (?, ?)
SQL;

    }
    
    /**
     * @return mysqli
     */
    private function getSQLConnection()
    {
        return new mysqli($this->host, $this->sqlUsername, $this->sqlPassword, self::DATABASE);
    }


}

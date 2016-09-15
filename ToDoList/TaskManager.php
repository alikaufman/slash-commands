<?php

require_once "Task.php";

class TaskManager
{
    /**
     * @param string $name
     * @return Task
     */
    public function addTask($name)
    {
        $task = new Task($name);
        //persist to database
        
        return $task;
    }
}

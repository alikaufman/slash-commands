<?php


class Task
{
    /** @var  string */
    private $name;
    
    /** @var DateTime  */
    private $createdAt;
    
    /** @var  DateTime */
    private $dueDate;
    
    /** @var string  */
    private $status;
    
    /** @var string */
    private $description;
    
    public function __construct($name)
    {
        $this->name = $name;
        $this->status = 'backlog';
        $this->createdAt = new DateTime();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param DateTime $dueDate
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("Task: %s\nCreated %s\nDue: %s\nStatus: %s\nDescription: %s",
                $this->name,
                $this->createdAt->format('M-d-Y'),
                $this->dueDate->format('M-d-Y'),
                $this->status,
                $this->description
            );
    }

    /**
     * @return array
     */
    public function __toArray()
    {
        return [
            "name" => $this->name,
            "createdAt" => $this->createdAt,
            "dueDate" => $this->dueDate,
            "status" => $this->status,
            "description" => $this->description,
        ];
    }
}

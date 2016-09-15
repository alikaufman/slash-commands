<?php


class Task
{
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in progress';
    const STATUS_COMPLETED = 'completed';

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

    private static $validStatuses = [
        self::STATUS_NEW,
        self::STATUS_IN_PROGRESS,
        self::STATUS_COMPLETED,
    ];
    
    public function __construct($name)
    {
        $this->name = $name;
        $this->status = self::STATUS_NEW;
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
    public function setDueDate(DateTime $dueDate)
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
        if ($this->isValidStatus($status)) {
            $this->status = $status;
        }
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
        $dueDate = $this->dueDate ? $this->dueDate->format('D, M d Y'): 'n/a';
        $description = $this->description ?: 'n/a';
        
        return sprintf("Task: %s\nCreated: %s\nDue: %s\nStatus: %s\nDescription: %s",
                $this->name,
                $this->createdAt->format('D, M d Y'),
                $dueDate,
                $this->status,
                $description
            );
    }

    /**
     * @param string $status
     * @return bool
     */
    private function isValidStatus($status)
    {
        return in_array($status, self::$validStatuses);
    }
}

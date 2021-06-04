<?php

# this file is just an example that should not be taken into consideration and that can be deleted at any time!

namespace AjdainiPHP\Entity;
use AjdainiPHP\Core\Entity\Entity;

class SampleEntity extends Entity
{
    public function getTitle(): string
    {
        return ucfirst($this->$title);
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function shortDescription(): string
    {
        return substr($this->description, -30);
    }
}

?>
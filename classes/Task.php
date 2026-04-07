<?php

class Task {
    private $id;
    private $title;
    private $status;

    // Constructor 
    public function __construct($id, $title, $status = "pending") {
        $this->id = $id;
        $this->title = $title;
        $this->status = $status;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getStatus() {
        return $this->status;
    }

    // Setters
    public function setTitle($title) {
        $this->title = $title;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    // Converting object to array because PHP objects cannot be saved directly in JSON file
    public function toArray() {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "status" => $this->status
        ];
    }
}
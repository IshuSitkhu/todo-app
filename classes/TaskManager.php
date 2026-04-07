<?php

require_once "Task.php";

class TaskManager {

    private $file;

    public function __construct($filePath = null) {
        // Always safe absolute path
        $this->file = $filePath ?? __DIR__ . "/../data/tasks.json";

        // Ensure file exists (IMPORTANT FIX)
        if (!file_exists($this->file)) {
            if (!is_dir(dirname($this->file))) {
                mkdir(dirname($this->file), 0777, true);
            }
            file_put_contents($this->file, json_encode([]));
        }
    }

    private function getTasks() {
        $data = file_get_contents($this->file);
        return $data ? json_decode($data, true) : [];
    }

    private function saveTasks($tasks) {
        file_put_contents($this->file, json_encode($tasks, JSON_PRETTY_PRINT));
    }

    public function getAllTasks() {
        return $this->getTasks();
    }

    public function addTask($title) {

        $title = trim($title); 

        if (empty($title)) {
            return ["success" => false, "message" => "Title cannot be empty"];
        }

        $tasks = $this->getTasks();

        $taskObj = new Task(time(), $title);

        $tasks[] = $taskObj->toArray();

        $this->saveTasks($tasks);

        return ["success" => true, "message" => "Task added successfully"];
    }

    public function updateTask($id, $title, $status) {

        $title = trim($title); 

        if (empty($title)) {
            return ["success" => false, "message" => "Title cannot be empty"];
        }

        if (!in_array($status, ["pending", "completed"])) {
            return ["success" => false, "message" => "Invalid status"];
        }

        $tasks = $this->getTasks();

        foreach ($tasks as &$task) {
            if ($task["id"] == $id) {
                $task["title"] = $title;
                $task["status"] = $status;

                break;
            }
        }

        $this->saveTasks($tasks);

        return ["success" => true, "message" => "Task updated successfully"];
    }

    public function deleteTask($id) {

        $tasks = $this->getTasks();

        $tasks = array_filter($tasks, function($task) use ($id) {
            return $task["id"] != $id;
        });

        $this->saveTasks(array_values($tasks));

        return ["success" => true, "message" => "Task deleted successfully"];
    }

    public function deleteAllTasks() {
        file_put_contents($this->file, json_encode([]));

        return [
            "success" => true,
            "message" => "All tasks deleted successfully"
        ];
    }
}
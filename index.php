<?php

require_once "classes/TaskManager.php";

$taskManager = new TaskManager();

if (isset($_POST['add'])) {
    $taskManager->addTask($_POST['title']);
    header("Location: index.php?msg=add");
    exit();
}

if (isset($_POST['update'])) {
    $taskManager->updateTask(
        $_POST['id'],
        $_POST['title'],
        $_POST['status']
    );
    header("Location: index.php?msg=update");
    exit();
}

if (isset($_POST['delete'])) {
    $taskManager->deleteTask($_POST['id']);
    header("Location: index.php?msg=delete");
    exit();
}

if (isset($_POST['delete_all'])) {
    $taskManager->deleteAllTasks();
    header("Location: index.php?msg=delete_all");
    exit();
}

$tasks = $taskManager->getAllTasks();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Todo App- Ishu Sitikhu</title>

    <link rel="stylesheet" href="style.css">

    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<h1>Todo List App</h1>

<!-- ADD TASK -->
<form method="POST">
    <input type="text" name="title" placeholder="Enter task title" required>
    <button type="submit" name="add">Add Task</button>
</form>

<!-- DELETE ALL -->
<?php if (!empty($tasks)): ?>
    <form method="POST"
          onsubmit="return confirm('Are you sure you want to delete ALL tasks?')"
          style="text-align:center; margin-bottom:20px;">
        <button type="submit" name="delete_all" style="background:red;color:white;">
            Delete All Tasks
        </button>
    </form>
<?php endif; ?>

<hr>

<h2>Tasks</h2>

<?php if (empty($tasks)): ?>

    <p class="no-tasks">No tasks added yet</p>

<?php else: ?>

    <?php foreach ($tasks as $task): ?>
        <div class="task">

            <form method="POST">
                <input type="hidden" name="id" value="<?= $task['id'] ?>">

                <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>">

                <select name="status">
                    <option value="pending" <?= $task['status'] == "pending" ? "selected" : "" ?>>
                        Pending
                    </option>
                    <option value="completed" <?= $task['status'] == "completed" ? "selected" : "" ?>>
                        Completed
                    </option>
                </select>

                <button type="submit" name="update">Update</button>
                <button type="submit" name="delete">Delete</button>
            </form>

        </div>
    <?php endforeach; ?>

<?php endif; ?>

<!-- SWEETALERT (FIXED)-->
<?php if (isset($_GET['msg'])): ?>

<script>
let msg = "<?= $_GET['msg'] ?>";

let message = "";
let icon = "success";

switch (msg) {

    case "add":
        message = "Task added successfully";
        icon = "success";
        break;

    case "update":
        message = "Task updated successfully";
        icon = "success";
        break;

    case "delete":
        message = "Task deleted successfully";
        icon = "success";
        break;

    case "delete_all":
        message = "All tasks deleted successfully";
        icon = "success";
        break;

    default:
        message = "Action completed";
        icon = "info";
}

Swal.fire({
    title: "Message",
    text: message,
    icon: icon
});
</script>

<?php endif; ?>

</body>
</html>
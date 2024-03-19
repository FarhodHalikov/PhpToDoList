<?php

    $errors = "";

    //connection to the database that has been created previously
    // database_name = todolist_db; tables = tasks (int id, string[255] task),
    $db = mysqli_connect('localhost', 'root', '', 'todolist_db');


    // if post request to the database is 'submit'(the method to add the data) then we create the data 
    // submit is one of the button types
    if (isset($_POST['submit'])){
        $task = $_POST['task'];
        //if condition for trying to add empty task following with error message
        if (empty($task)){
            $errors = "Task CANNOT be empty!";
        }else{
            mysqli_query($db, "INSERT INTO tasks (task) VALUES ('$task')");
            header('location: index.php');
        }
        
    }
    //detele task fucntion
    if (isset($_GET['del_task'])){
        $id = $_GET['del_task'];
        mysqli_query($db, "DELETE FROM tasks WHERE id=$id");
        header('location: index.php');
    }

    $tasks = mysqli_query($db, "SELECT * FROM tasks");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>ToDo app by Farhod Halikov</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
<body>
    <div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li style="float:right"><a class="active" href="about.php">About</a></li>
        </ul>
    </div>
    <!-- Heading -->
    <div class="class heading">
        <h2>To do list</h2>
    </div>
    <!-- Adding task form including the Add button -->
    <form method="POST" action="index.php">
        <!-- Printing out the erros if there are any of em -->
        <?php if (isset($errors)){ ?>
            <p><?php echo $errors; ?></p>
        <?php }?>
        <input type="text" name="task" class="task_input">
        <button type="submit" class="add_task_btn" name="submit">Add Task</button>
    </form>
    
    <!-- Already existing tasks lists where you can delete them or accomplish -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>To-do task</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Looping while the data in tasks table exists that is not NULL -->
            <!-- i starting from 1 to write down the ids the correct order, iteration is in the end -->
            <?php $i = 1;while ($row = mysqli_fetch_array($tasks)){ ?>
                    <tr>
                    <!-- Entering all the ids from database -->
                    <td><?php echo $i; ?></td>
                    <td class="task" type="text"><?php echo $row['task']; ?></td>
                    <td class="delete">
                        <a href="index.php?del_task=<?php echo $row['id']; ?>">x</a>
                    </td>
                </tr>
                <?php $i++;} ?>
            
        </tbody>
    </table>
</body>
</html>
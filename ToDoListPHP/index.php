<?php
$errors = "";
$task = "";

$db = mysqli_connect("localhost", "root", "", "todo"); // connect to database

// if Add button is clicked
if (isset($_POST['Add'])) {   
    if (empty($_POST['task'])) {  // checks if task input is empty
        $errors = "You must fill in the task";
    }else{
        $tasks = $_POST['task'];     
        $sql = "INSERT INTO tasks (task) VALUES ('$tasks')";  // insert into db in colum task, values tasks
        mysqli_query($db, $sql);  // make query to db
    }
}	

if(isset($_GET['edit_task'])){  // if edit button is clicked
    $id = $_GET['edit_task'];   
    $sql1 = "SELECT * FROM tasks WHERE id='$id'";
    $task = $db->query($sql1); // make query to db to find the task with same id
    $row= $task->fetch_array(); // get the task as an array
    $task=$row['task']; 
    
    if (isset($_POST['Add'])) { 
        $task = $_GET['task'];     

        $sql = "INSERT INTO tasks (task) VALUES ('$task')";  // insert into db 
        mysqli_query($db, $sql); 
    }

    $sql2 = "DELETE FROM tasks WHERE id='$id'";
    mysqli_query($db, $sql2);
}

// works
if (isset($_GET['del_task'])) {   // if del_task is clicked
   $id = $_GET['del_task'];

   mysqli_query($db, "DELETE FROM tasks WHERE id=".$id);  // make query to db and delete the task with this id
}

?>

<!DOCTYPE HTML>
<html>
    <head>
       <meta lang="en"> <meta lang="bg">
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link rel="stylesheet" href = "style.css" >
       <title>ToDo List</title>
    </head>

    <body>
    <div class = "box">
        <div class = "header">
            <p>ToDo List</p>
        </div>
    
        <form method="post" action="index.php" accept="index.php" class="input_form">
       
          <!-- show the error, if it's empty -->
	    <p><?php echo $errors; ?></p>     

        <input type = "text" name = "task" value="<?php echo $task ?>" placeholder="Task" class="input-task">
        <button type = "Add" name = "Add" id = "add_btn" class="add_btn">Add Task</button>
        
        </form>
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;">N</th>
                    <th style="width: 200x;">Task</th>
                    <th style="width: 30px; float:center;">Action</th>
                    <th style="width: 30px;"></th>
                </tr>
            </thead>
           
	      <tbody>
                <?php 
                // select all tasks from db
                $tasks = mysqli_query($db, "SELECT * FROM tasks");  
                $i = 1; while ($row = mysqli_fetch_array($tasks)) {  // fetching records from the database
                ?>  

                <tr>
                    <td> <?php echo $i; echo"|"; ?> </td> 
                    <td class="task"> <?php echo $row['task']; ?> </td> 
                    
                    <td class="edit"> 
                        <a href="index.php?edit_task=<?php echo $row['id'] ?>">edit</a>
                    <td class="delete"> 
                        <a href="index.php?del_task=<?php echo $row['id'] ?>">delete</a> 
                    </td>
                </tr>

            <?php $i++; } ?>  

	       </tbody>
        </table>
      </div>
    </div>
    </body>
</html>
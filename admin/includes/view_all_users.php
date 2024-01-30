<?php
if(isset($_POST['checkBoxArray'])){
    foreach(($_POST['checkBoxArray']) as $bulk_user_id){
        $bulk_options = $_POST['bulk_options'];
        switch($bulk_options){
            case 'Admin':
                $query = "UPDATE users SET user_role='{$bulk_options}' WHERE user_id = {$bulk_user_id}";
                $update_status_as_published = mysqli_query($conn, $query);
                confirmQuery($update_status_as_published);
            break;

            case 'Subscriber':
                $query = "UPDATE users SET user_role='{$bulk_options}' WHERE user_id = {$bulk_user_id}";
                $update_status_as_draft = mysqli_query($conn, $query);
                confirmQuery($update_status_as_draft);
            break; 

            case 'delete':
                $query = "DELETE FROM users WHERE user_id = {$bulk_user_id}";
                $delete_post_as_bulk = mysqli_query($conn, $query);
                confirmQuery($delete_post_as_bulk);
            break; 
        }
    }
}
?>
<form action="" method="post">

    <table class="table table-bordered table-hover">

        <div id="bulkOptionContainer" class="col-xs-4" style="padding: 0px">
            <select class="form-control" name="bulk_options" id="">
                <Option value="">Select Options</Option>
                <Option value="Admin">Admin</Option>
                <Option value="Subscriber">Subscriber</Option>
                <Option value="delete">Delete</Option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
        </div>
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>Username</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>User Email</th>
                <th>Role</th>
                <th>Date</th>
                <th>Change Role</th>
                <th>Change Role</th>
                <th>Edit user</th>
                <th>Delete</th>
            </tr>
        </thead>                
        <tbody>
        <?php
            $query = "SELECT * FROM users";
            $selectAllUsers = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($selectAllUsers)){
                $user_id = $row['user_id'];
                $username = $row['username'];
                $user_password =  $row['user_password'];
                $firstname = $row['firstname'];
                $lastname = $row['lastname'];
                $user_email = $row['user_email'];
                $user_image = $row['user_image'];
                $user_role = $row['user_role'];
                $date = $row['reg_date'];
            echo "<tr>";
                echo "<th><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value={$user_id}></th>";
                echo "<td>$user_id</td>";
                echo "<td>$username</td>";
                echo "<td>$firstname</td>";
                echo "<td>$lastname</td>";
                echo "<td>$user_email</td>";
                echo "<td>$user_role</td>";
                echo "<td>$date</td>";
                echo "<td><a href='users.php?change_to_sub={$user_id}'>Subscriber</a></td>";
                echo "<td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
                echo "<td><a href ='users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>";
                echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";

            echo "</tr>";
            }
        ?>                        
        </tbody>
    </table>
</form>
<a href=""></a>
<?php 
if(isset($_GET["change_to_sub"])){
    $the_user_id = escape($_GET["change_to_sub"]);

    $query = "UPDATE users SET user_role='Subscriber' WHERE user_id = {$the_user_id}";
    $change_to_sub_query = mysqli_query($conn, $query);
    header("Location: users.php");
}

if(isset($_GET["change_to_admin"])){
    $the_user_id = escape($_GET["change_to_admin"]);
    
    $query = "UPDATE users SET user_role='Admin' WHERE user_id = {$the_user_id}";
    $change_to_admin_query = mysqli_query($conn, $query);
    header("Location: users.php");
}

if(isset($_GET["delete"])){
    if(isset($_SESSION['user_role'])){
        if($_SESSION['user_role'] == 'Admin'){
            $the_user_id = escape($_GET["delete"]);
            $query = "DELETE FROM users WHERE user_id = {$the_user_id}";
            $delete_user_query = mysqli_query($conn, $query);
            header("Location: users.php");
        }
    }

}

?>

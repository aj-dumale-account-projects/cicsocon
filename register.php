<?php
// core configuration
include_once "config/core.php";
// set page title
$page_title = "Register";
// include login checker
include_once "login_checker.php";
// include classes
include_once 'config/database.php';
include_once 'objects/user.php';
include_once "libs/php/utils.php";
// include page header HTML
include_once "layout_head.php";
echo "<div class='col-md-12'>";

// code when form was submitted will be here
// if form was posted
if($_POST){
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    // initialize objects
    $user = new User($db);
    $utils = new Utils();
    // set user email to detect if it already exists
    $user->email_address=$_POST['email_address'];
    // check if email already exists
    if($user->emailExists()){
        echo "<div class='alert alert-danger'>";
            echo "The email you specified is already registered. Please try again or <a href='{$home_url}login'>login.</a>";
        echo "</div>";
    }
    else{
        // create user will be here
        // set values to object properties
        $user->firstname=$_POST['firstname'];
        $user->middlename=$_POST['middlename'];
        $user->lastname=$_POST['lastname'];
        $user->password=$_POST['password'];
        $user->access_level='Student';
        //$user->status=1;
        // create the user
        if($user->create()){
            echo "<div class='alert alert-info'>";
                echo "Successfully registered. <a href='{$home_url}login'>Please login</a>.";
            echo "</div>";
            // empty posted values
            $_POST=array();
        }else{
            echo "<div class='alert alert-danger' role='alert'>Unable to register. Please try again.</div>";
        }
    }
}
?>
<form action='register.php' method='post' id='register'>
    <table class='table table-responsive'>
        <tr>
            <td class='width-30-percent'>Firstname</td>
            <td><input type='text' name='firstname' class='form-control' required value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname'], ENT_QUOTES) : "";  ?>" /></td>
        </tr>
        <tr>
            <td>Middlename</td>
            <td><input type='text' name='middlename' class='form-control' required value="<?php echo isset($_POST['middlename']) ? htmlspecialchars($_POST['middlename'], ENT_QUOTES) : "";  ?>" /></td>
        </tr>

        <tr>
            <td>Lastname</td>
            <td><input type='text' name='lastname' class='form-control' /></td>
        </tr>
        <tr>
        <tr>
            <td>Email Address</td>
            <td><input type='email' name='email_address' class='form-control' required value="<?php echo isset($_POST['email_address']) ? htmlspecialchars($_POST['email_address'], ENT_QUOTES) : "";  ?>" /></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type='password' name='password' class='form-control' required id='passwordInput'></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span> SignUp
                </button>
            </td>
        </tr>
    </table>
</form>
<?php

echo "</div>";
// include page footer HTML
include_once "layout_foot.php";
?>
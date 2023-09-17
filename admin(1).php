<!DOCTYPE html>
<html>
<head>
<title>Bus Route Finder</title>
<?php
    include('includes/header.php');
?>
</head>
<body>
<?php
    include('includes/navigation.php');
?>
    <div class="image-ban">
        <div class="col-lg-4 login-form">
             <h2> Admin Login </h2>
            <form action="admin/admin_login.php" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="user" class="form-control" required="">    
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="Password" name="Password" class="form-control" required="">    
                </div>
                <div id="error" style="color: red; font-size:1em;">
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
             <?php
                    if (isset($_GET['login_failed'])){
                ?>
                    <script>
                        error();
                        function error() {
                            document.getElementById("error").innerHTML = "*please enter valid username and password..";
                        }
                    </script>
                <?php
                    }
                ?>
        </div>
    </div>
<?php
    include('includes/footer.php');
?>
</body>
</html>
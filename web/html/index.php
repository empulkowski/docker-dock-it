<?php
include "includes/header.php";
?>


    <div class="welcome">
        <h8>Welcome to Rock Collector!</h8>
        <br>
        <h9>Collecting rocks and minerals is an exciting and rewarding hobby,
            full of fun and adventure.<br>
            Sign up or Sign in below, to track your collection!
        </h9>
    </div>

    <div class="container login-container">


        <div class="row">
            <div class="col-md-6 login-form-1">
                <h3>Sign Up</h3>
                <?php
                $accountCreated = false;

                if (isset($_POST['signup'])) {
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    $password = password_hash($password, PASSWORD_DEFAULT);

                    // add user to database
                    $query = "INSERT INTO `Users` 
                                (`UserId`,`Email`, `Password`, `Role`) 
                            VALUES 
                                (NULL, ?, ?, 'user');";

                    $stmt = mysqli_prepare($db, $query);
                    mysqli_stmt_bind_param($stmt, 'ss', $email, $password);
                    mysqli_stmt_execute($stmt);


                    //check if record was created
                    if (mysqli_insert_id($db)) {
                        $accountCreated = true;
                        echo '<div class="alert alert-success">
                          <b>Account created!</b><br>Please login.
                        </div>';

                    } else {
                        echo '<div class="alert alert-danger">
                          <b>Error creating account!</b><br> 
                        </div>';
                    }
                }
                ?>

                <?php if (!$accountCreated): ?>


                    <form method="post">
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" placeholder="" value="email">
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder=""
                                   value="password">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="signup" class="btnSubmit" value="signup">
                        </div>
                    </form>
                <?php endif; ?>
            </div>


            <div class="col-md-6 login-form-2">
                <h3>Login</h3>
                <?php
                if (isset($_POST['login'])) {
                    // get form values
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    $query = "SELECT Email, Password, Role  FROM Users WHERE Email = ?";
                    $stmt = mysqli_prepare($db, $query);
                    mysqli_stmt_bind_param($stmt, 's', $email);
                    mysqli_stmt_bind_result($stmt, $email, $hashed_password, $role);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_fetch($stmt);

                    if ($email && $hashed_password) {
                        if (password_verify($password, $hashed_password)) {
                            if (password_needs_rehash($hashed_password, PASSWORD_DEFAULT)) {
                                $hashed_password = password_hash($password, PASSWORD_DEFAULT);


                            }

                            $_SESSION['Users']['Email'] = $email;
                            $_SESSION['Users']['Role'] = $role;


                            header('Location: collection.php');
                        }
                    }


                    echo '<div class="alert alert-danger">Email or password was incorrect.</div>';
                }


                if (isset($_GET['logout'])) {
                    // remove session data
                    unset($_SESSION['Users']);


                    session_destroy();

                    header("Location: index.php");
                }

                ?>
                <?php if (isset($_SESSION['Users'])): ?>
                    <form method="get">
                        <input type="submit" name="logout" class="btnSubmit" value="Log Out">
                    </form>
                <?php else: ?>
                    <form method="post">
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" placeholder="Your Email *" value="">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Your Password *"
                                   value="">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="login" class="btnSubmit" value="Login">
                        </div>
                    </form>
                <?php endif; ?>


            </div>
        </div>
    </div>


    <div class="article">
        <h8>CHECK IT OUT!</h8>
        <br>
        <h9><a href="RockLocations.php">Rocks to not Take for Granite... and Where You Can Find Them!
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                </svg>
            </a></h9>
    </div>


<?php
include "includes/footer.php";
?>
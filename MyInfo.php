<?php
    session_start();
    $Username_From_Session = $_SESSION['username'];
    require_once 'database_config.php';
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    //Collect Things from Mysql
    $sql = "SELECT * FROM user WHERE username='$Username_From_Session'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Password = $row['password'];
        $IsStaff = $row['is_staff'];
        $Email = $row['email'];
        $Phone = $row['phone'];
        $Address = $row['address'];
    }
    //Update
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $NewPhone = $_POST['phone'];
        $NewAddress = $_POST['address'];
        $NewEmail = $_POST['email'];
        $update_sql = "UPDATE user SET phone='$NewPhone', address='$NewAddress', email='$NewEmail' WHERE username='$Username_From_Session'";
        if ($conn->query($update_sql) === TRUE) {
            // Update successful
            $Phone = $NewPhone;
            $Address = $NewAddress;
            $Email = $NewEmail;
        }
    }
    $conn->close();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>My Information</title>
    </head>
    <style>
        body{
            margin: 0;
            text-align: center;
        }
        .center{
            width: 300px;
            margin: 0 auto;
        }
    </style>
    <body>
        <div class="center">
            <div class="Personal">
                <h3><?php echo $Username_From_Session;?>'s Information</h3>
                <p>Username: <?php echo $Username_From_Session; ?></p>
                <p>Password: <?php echo $Password; ?></p>
                <p>Is Staff: <?php echo ($IsStaff == 1) ? "Yes" : "No"; ?></p>
                <p>Email: <?php echo $Email; ?></p>
                <p>Phone: <?php echo $Phone; ?></p>
                <p>Address: <?php echo $Address; ?></p>
            </div>
            <div class="Update">
                <h3>Edit Information</h3>
                <form method="post">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br><br>
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" required><br><br>
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required><br><br>
                    <input type="submit" value="Update Information">
                </form>
            </div>
        </div>
        <a href="landing.php"><button>Back</button></a>
    </body>
</html>

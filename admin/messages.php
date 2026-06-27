<?php include("../db.php"); ?>
<?php $activePage = 'messages'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Purity Admin - Messages</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body class="admin-body">

<div class="admin-wrapper">

    <?php include("sidebar.php"); ?>

    <main class="admin-main">

        <div class="products-topbar">
            <h1>Contact Messages</h1>
        </div>

        <div class="table-card">

            <table class="product-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Received</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY id DESC");

                    if($result && mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            echo '<tr>';
                            echo '<td>'.$row['id'].'</td>';
                            echo '<td>'.htmlspecialchars($row['name']).'</td>';
                            echo '<td>'.htmlspecialchars($row['email']).'</td>';
                            echo '<td>'.htmlspecialchars($row['message']).'</td>';
                            echo '<td>'.date('d M Y, h:i A', strtotime($row['created_at'])).'</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5" style="text-align:center;padding:30px;">No messages yet.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>

        </div>

    </main>

</div>

</body>
</html>
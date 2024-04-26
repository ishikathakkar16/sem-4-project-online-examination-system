<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending and Approved Users</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
        }

        th {
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Pending List</h1>
    <?php
    require_once("conn.php");

    $records_per_page = 2; // Define the number of records per page
    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $start_from = ($current_page - 1) * $records_per_page;

    $fetch = "SELECT * FROM user WHERE status = 'pending' LIMIT $start_from, $records_per_page";
    $result = mysqli_query($conn, $fetch);

    echo "<table>";
    echo "<tr><th>Name</th><th>Username</th><th>Mobile No</th><th>User Category</th><th>Status</th></tr>";

    while ($record = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($record["name"]) . "</td>";
        echo "<td>" . htmlspecialchars($record["username"]) . "</td>";
        echo "<td>" . htmlspecialchars($record["mobileno"]) . "</td>";
        echo "<td>" . htmlspecialchars($record["user_category"]) . "</td>";
        echo "<td>";
        echo "<form action='admin_interface.php' method='POST'>";
        echo "<input type='hidden' name='id' value='" . $record['user_id'] . "'>";
        echo "<input type='submit' name='approve' value='Approve'>";
        echo "<input type='submit' name='reject' value='Reject'> ";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";

    $query = "SELECT COUNT(*) AS total FROM user WHERE status = 'pending'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $total_records = $row['total'];
    $total_pages = ceil($total_records / $records_per_page);

    echo "<div>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='?page=$i'>$i</a> ";
    }
    echo "</div>";

    if (isset($_POST['approve'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $query = "UPDATE user SET status = 'approved' WHERE user_id = '$id'";
        mysqli_query($conn, $query);
        header("location: admin_interface.php");
    }

    if (isset($_POST['reject'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $query = "DELETE FROM user WHERE user_id = '$id'";
        mysqli_query($conn, $query);
        header("location: admin_interface.php");
    }
    ?>

    <h1>Approval List</h1>
    <?php
    $records_per_page = 2;
    $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
    $start_from = ($current_page - 1) * $records_per_page;

    $query2 = "SELECT * FROM user WHERE status = 'approved' LIMIT $start_from, $records_per_page";
    $result = mysqli_query($conn, $query2);

    echo "<table>";
    echo "<tr><th>Name</th><th>Username</th><th>Mobile No</th><th>User Category</th><th>Status</th></tr>";

    while ($record = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($record["name"]) . "</td>";
        echo "<td>" . htmlspecialchars($record["username"]) . "</td>";
        echo "<td>" . htmlspecialchars($record["mobileno"]) . "</td>";
        echo "<td>" . htmlspecialchars($record["user_category"]) . "</td>";
        echo "<td>" . htmlspecialchars($record["status"]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    $query = "SELECT COUNT(*) AS total FROM user WHERE status = 'approved'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $total_records = $row['total'];
    $total_pages = ceil($total_records / $records_per_page);

    echo "<div>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='?page=$i'>$i</a> ";
    }
    echo "</div>";
    ?>

</body>

</html>
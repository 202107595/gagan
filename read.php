<?php
require_once "config.php";

$id = $_GET["id"] ?? null;

if (!isset($id) || empty($id)) {
    header("location: error.php");
    exit();
}

$sql = "SELECT * FROM products WHERE id = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $param_id);
    $param_id = $id;
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $name = $row["name"];
            $description = $row["description"];
            $price = $row["price"];
        } else {
            header("location: error.php");
            exit();
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}
mysqli_stmt_close($stmt);
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Product</title>
    <link rel="stylesheet" href="../styles/style.css">

</head>
<body>
    <header>
    <h2>View Product</h2>
    </header>
    <div>
        <label>Name:</label>
        <span><?php echo $name; ?></span>
    </div>
    <div>
        <label>Description:</label>
        <span><?php echo $description; ?></span>
    </div>
    <div>
        <label>Price:</label>
        <span><?php echo $price; ?></span>
    </div>
    <a href="../products.php">Back</a>
</body>
</html>

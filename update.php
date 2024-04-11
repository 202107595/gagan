<?php
require_once "config.php";

$name = $description = $price = "";
$name_err = $description_err = $price_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } else {
        $name = $input_name;
    }

    $input_description = trim($_POST["description"]);
    if (empty($input_description)) {
        $description_err = "Please enter a description.";
    } else {
        $description = $input_description;
    }

    $input_price = trim($_POST["price"]);
    if (empty($input_price)) {
        $price_err = "Please enter the price.";
    } else {
        $price = $input_price;
    }

    if (empty($name_err) && empty($description_err) && empty($price_err)) {
        $sql = "UPDATE products SET name=?, description=?, price=? WHERE id=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssdi", $param_name, $param_description, $param_price, $param_id);

            $param_name = $name;
            $param_description = $description;
            $param_price = $price;
            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                header("location: ../products.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
} else {
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Product</title>
    <link rel="stylesheet" href="../styles/style.css">

</head>
<body>
<header>    <h2>Update Product</h2>
</header>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div>
            <label>Name</label>
            <input type="text" name="name" value="<?php echo $name; ?>">
            <span><?php echo $name_err; ?></span>
        </div>
        <div>
            <label>Description</label>
            <textarea name="description"><?php echo $description; ?></textarea>
            <span><?php echo $description_err; ?></span>
        </div>
        <div>
            <label>Price</label>
            <input type="text" name="price" value="<?php echo $price; ?>">
            <span><?php echo $price_err; ?></span>
        </div>
        <div>
            <input type="submit" value="Submit">
            <a href="../products.php">Cancel</a>
        </div>
    </form>
</body>
</html>

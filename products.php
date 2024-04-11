<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Page</title>
    <link rel="stylesheet" href="styles/products.css">
    <link rel="stylesheet" href="styles/style.css">

</head>

<body>
    <header>
        <h1>Our Products</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="about us.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    </header>

    <a href="back/create.php">Add new products</a>
<section class="products">
<?php
require_once "back/config.php";

$query = "SELECT * FROM products";
$result = mysqli_query($link, $query);
?>
<?php if (mysqli_num_rows($result) > 0) : ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td>
                        <a href="back/read.php?id=<?php echo $row['id']; ?>" title="View Record">View</a>
                        <a href="back/update.php?id=<?php echo $row['id']; ?>" title="Update Record">Update</a>
                        <a href="back/delete.php?id=<?php echo $row['id']; ?>" title="Delete Record">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>No records found.</p>
<?php endif; ?>
<?php mysqli_close($link); ?>

</section>
    <footer>
        <p>&copy; 2024 My Store. All rights reserved.</p>
    </footer>
</body>

</html>
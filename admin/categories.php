<?php include("../db.php"); ?>

<?php
if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}
?>

<?php $activePage = 'categories'; ?>

<?php
$message = "";

// ADD subcategory
if(isset($_POST['add_subcategory'])){
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $slug = strtolower(str_replace(' ', '-', $name));

    $stmt = mysqli_prepare($conn, "INSERT INTO subcategories (category_id, name, slug) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iss", $category_id, $name, $slug);
    mysqli_stmt_execute($stmt);

    header("Location: categories.php");
    exit();
}

// EDIT subcategory
if(isset($_POST['edit_subcategory'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $slug = strtolower(str_replace(' ', '-', $name));

    $stmt = mysqli_prepare($conn, "UPDATE subcategories SET name=?, slug=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssi", $name, $slug, $id);
    mysqli_stmt_execute($stmt);

    header("Location: categories.php");
    exit();
}

// DELETE subcategory
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM subcategories WHERE id=$id");
    header("Location: categories.php");
    exit();
}

$categories = mysqli_query($conn, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Purity Admin - Categories</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body class="admin-body">

<div class="admin-wrapper">

    <?php include("sidebar.php"); ?>

    <main class="admin-main">

        <div class="products-topbar">
            <h1>Categories</h1>
        </div>

        <?php
        mysqli_data_seek($categories, 0);
        while($cat = mysqli_fetch_assoc($categories)){
        ?>

            <div class="category-block">

                <div class="category-block-header">
                    <h3><?php echo $cat['name']; ?></h3>
                    <button class="btn-add" onclick="openAddModal(<?php echo $cat['id']; ?>)"><i class="fa fa-plus"></i> Add Subcategory</button>
                </div>

                <div class="table-card">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subcategory Name</th>
                                <th>Slug</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $subResult = mysqli_query($conn, "SELECT * FROM subcategories WHERE category_id=".$cat['id']);

                            if(mysqli_num_rows($subResult) > 0){
                                while($sub = mysqli_fetch_assoc($subResult)){
                                    echo '<tr>';
                                    echo '<td>'.$sub['id'].'</td>';
                                    echo '<td>'.htmlspecialchars($sub['name']).'</td>';
                                    echo '<td>'.$sub['slug'].'</td>';
                                    echo '<td class="action-icons">
                                            <i class="fa fa-pen edit-icon" onclick="openEditModal('.$sub['id'].', \''.htmlspecialchars($sub['name'], ENT_QUOTES).'\')"></i>
                                            <a href="categories.php?delete='.$sub['id'].'" onclick="return confirm(\'Delete this subcategory?\')"><i class="fa fa-trash delete-icon"></i></a>
                                          </td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4" style="text-align:center;padding:20px;">No subcategories yet.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>

        <?php } ?>

    </main>

</div>

<!-- ADD MODAL -->
<div id="addModal" class="modal-overlay">
    <div class="modal-box">
        <h3>Add Subcategory</h3>
        <form method="POST" action="categories.php">
            <input type="hidden" name="category_id" id="addCategoryId">
            <label>Subcategory Name</label>
            <input type="text" name="name" placeholder="e.g. Keychains" required>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModals()">Cancel</button>
                <button type="submit" name="add_subcategory" class="btn-submit">Add</button>
            </div>
        </form>
    </div>
</div>

<!-- EDIT MODAL -->
<div id="editModal" class="modal-overlay">
    <div class="modal-box">
        <h3>Edit Subcategory</h3>
        <form method="POST" action="categories.php">
            <input type="hidden" name="id" id="editSubId">
            <label>Subcategory Name</label>
            <input type="text" name="name" id="editSubName" required>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModals()">Cancel</button>
                <button type="submit" name="edit_subcategory" class="btn-submit">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal(categoryId){
    document.getElementById('addCategoryId').value = categoryId;
    document.getElementById('addModal').style.display = 'flex';
}

function openEditModal(id, name){
    document.getElementById('editSubId').value = id;
    document.getElementById('editSubName').value = name;
    document.getElementById('editModal').style.display = 'flex';
}

function closeModals(){
    document.getElementById('addModal').style.display = 'none';
    document.getElementById('editModal').style.display = 'none';
}
</script>

</body>
</html>
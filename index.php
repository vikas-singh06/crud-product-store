<?php
require("connection.php");
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

    <div class="container bg-dark text-light p-3 rounded my-4">
        <div class="d-flex align-items-center justify-content-between px-3">
            <h2>
                <a href="index.php" class="text-decoration-none text-white"> <i class="bi bi-phone-fill"></i> VS Product
                    Store</a>

            </h2>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addproduct">
                <i class="bi bi-bag-plus-fill me-2"></i> Add Product
            </button>

        </div>
    </div>

    <?php
    if (isset($_GET['alert'])) {
        if ($_GET['alert'] == 'img_upload') {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>upload failed</strong> due to some error.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        }
        if ($_GET['alert'] == 'add_failed') {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>img remove failed</strong> due to some error.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        }
    } elseif(isset($_GET['success'])) {
        if ($_GET['success'] == 'updated') {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>img updated</strong> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        if ($_GET['success'] == 'added') {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>img added success</strong> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        if ($_GET['success'] == 'removed') {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>img removed success</strong> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }


    ?>

    <div class="container mt-5">
        <table class="table table-hover text-center p-0">
            <thead class="bg-dark text-light">
                <tr>
                    <th width="10%" scope="col" class="rounded-start">S no.</th>
                    <th width="15%" scope="col">Image</th>
                    <th width="10%" scope="col">Name</th>
                    <th width="10%" scope="col">Price</th>
                    <th width="35%" scope="col">Description</th>
                    <th width="20%" scope="col" class="rounded-end">Action</th>

                </tr>
            </thead>
            <tbody class="bg-white">
                <?php
    
                $query = "SELECT * FROM `products`";
                $result = mysqli_query($con, $query);
                $i = 1;
                $fetch_src = FETCH_SRC;
                while ($fetch = mysqli_fetch_assoc($result)) {
                    echo <<<product
                    <tr class="align-middle">
                        <th scope="row">$i</th>
                        <td><img src="$fetch_src$fetch[image]" style="width:150px"></td>
                        <td>$fetch[name]</td>
                        <td>$$fetch[price]</td>
                        <td>$fetch[description]</td>
                        <td>
                        <a href="index.php?edit=$fetch[id]" class="btn btn-success"><i class="bi bi-pencil-square"></i></a>
                        <button onclick="confirm_rem($fetch[id])" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button>
                        </td>

                    </tr>
                    product;
                    $i++;
                }
                ?>

            </tbody>
        </table>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="addproduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="crud.php" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Product</h1>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Name</span>
                            <input type="text" class="form-control" name="name" placeholder="name" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Price</span>
                            <input type="text" class="form-control" name="price" placeholder="Price" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Description</span>
                            <textarea class="form-control" name="desc"></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupFile01">Image</label>
                            <input type="file" class="form-control" name="image" accept=".jpg,.png,.svg" required>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" name="addproduct">Add</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editproduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog">
            <form action="crud.php" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Product</h1>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Name</span>
                            <input type="text" class="form-control" name="name" id="editname" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Price</span>
                            <input type="text" class="form-control" name="price" id="editprice" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Description</span>
                            <textarea class="form-control" id="editdesc" name="desc"></textarea>
                        </div>
                        <img src="" id="editimage" alt="" width="100%" class="mb-3"><br>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupFile01">Image</label>
                            <input type="file" class="form-control" name="image" accept=".jpg,.png,.svg">
                        </div>
                        <input type="hidden" name="editpid" id="editpid" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" name="editproduct">Edit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script>
        function confirm_rem(id) {
            if (confirm("Are you sure you want to delete this item ?")) {
                window.location.href = "crud.php?rem=" + id;
            }
        }
    </script>
    <?php
    if (isset($_GET['edit']) && $_GET['edit'] > 0) {
        $query = "SELECT * FROM `products` WHERE id = $_GET[edit]";
        $result = mysqli_query($con, $query);
        $fetch = mysqli_fetch_assoc($result);

        echo "
            <script>
            
            var editModal = new bootstrap.Modal(document.getElementById('editproduct'), {
                keyboard: false
              });
              document.querySelector('#editname').value=`$fetch[name]`;
              document.querySelector('#editprice').value=`$fetch[price]`;
              document.querySelector('#editdesc').value=`$fetch[description]`;
              document.querySelector('#editimage').src=`$fetch_src$fetch[image]`;
              document.querySelector('#editpid').value=`$fetch[id]`;
            
              editModal.show();
            </script>
            ";
    }
    ?>

</body>

</html>
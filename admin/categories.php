<?php include "includes/header.php" ?>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <?php include "includes/navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small>Author</small>
                        </h1>
                        <!-- add categories -->
                            <?php addCategories(); ?>

                        <div class="col-lg-6">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat_title">Add Category</label>
                                    <input type="text" class="form-control" name="cat_title">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Add Category">
                                </div>
                            </form>
                            <?php 
                            if(isset($_GET['edit'])){
                                $the_cat_id = escape($_GET['edit']);

                                include "includes/update_categories.php";
                            }
                            ?>

                        <div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                            <th>Id</th>
                                            <th>Category Title</th>                            
                                    </tr>
                                </thead>
                                <tbody>
                    <!-- gets all categories -->
                    <?php getAllCategories(); ?>
                    <!-- detete categories -->
                    <?php deleteCategories(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

<?php include "includes/footer.php" ?>
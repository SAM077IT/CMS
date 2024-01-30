<?php //updates in table categories
                            if(isset($_POST['submit-update'])){
                                $cat_title = escape($_POST['cat_title']);

                                if($cat_title =="" || empty($cat_title)){
                                    echo "This field should not be empty";
                                }
                                else{
                                    $query = "UPDATE categories SET cat_title = '{$cat_title}' WHERE cat_id = {$the_cat_id}";
                                    
                                    $update_cat_query = mysqli_query($conn, $query);

                                    if(!$update_cat_query){
                                        die('QUERY FAILED'. mysqli_error($conn));
                                    }
                                }
                            }
                            ?>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat_title">Edit Category</label>
                    
                                        <?php //Edit categories
                                        if(isset($_GET['edit'])){
                                            $the_cat_id = escape($_GET['edit']);
                                            $query = "SELECT * FROM categories WHERE cat_id = {$the_cat_id}";
                                            $edit_query = mysqli_query($conn, $query);
                                            
                                            while($row = mysqli_fetch_assoc($edit_query)){
                                                $edit_cat_id = escape($row['cat_id']);
                                                $edit_cat_title = escape($row['cat_title']);
                                        ?>
                                        <input value="<?php if(isset($edit_cat_title)){echo $edit_cat_title;} ?>" type="text" class="form-control" name="cat_title">
                                        <?php        
                                            }
                                        }
                                        ?>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="submit-update" value="Update Category">
                                </div>
                            </form>
                        </div>
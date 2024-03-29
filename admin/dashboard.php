<?php include "includes/header.php";?>
<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>  
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to the Admin Dashboard
                        <small> <?php echo getUsername(); ?></small>
                    </h1>
                </div>
            </div>
       
            <!---------- /.row ------------------>  
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php 
                                    $all_user_posts = query("SELECT * FROM posts WHERE user_id =" . LoggedInUserID() . "");
                                    confirmQuery($all_user_posts);
                                    $post_count = mysqli_num_rows($all_user_posts);
                                echo  "<div class='huge'>{$post_count}</div>"
                                    ?>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $select_user_posts_comments = query("SELECT * FROM posts INNER JOIN comments ON comments.comment_post_id = posts.post_id AND posts.user_id =" . LoggedInUserID() . "");
                                        $comment_count = mysqli_num_rows($select_user_posts_comments);
                                        echo  "<div class='huge'>{$comment_count}</div>"
                                    ?>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comment.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
                                        $query = "SELECT * FROM categories WHERE user_id = " .LoggedInUserID(). "";
                                        $select_all_categories = mysqli_query($conn,$query);
                                        $category_count = mysqli_num_rows($select_all_categories);
                                        echo  "<div class='huge'>{$category_count}</div>"
                                    ?>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-------------- /.row -------------->                  
            <?php
                $posts_query_result =query("SELECT * FROM posts WHERE post_status = 'published' AND user_id =" . LoggedInUserID() . "");
                confirmQuery($posts_query_result);
                $post_published_count = mysqli_num_rows($posts_query_result);
                                                    
                $draft_posts_query = query("SELECT * FROM posts WHERE post_status = 'draft' AND user_id =" . LoggedInUserID() . "");
                confirmQuery($draft_posts_query);
                $post_draft_count = mysqli_num_rows($draft_posts_query);

                $unapproved_comment_query = query("SELECT * FROM posts INNER JOIN comments ON comments.comment_post_id = posts.post_id AND posts.user_id =" . LoggedInUserID() . " AND comments.comment_status = 'unapproved'");
                confirmQuery($unapproved_comment_query);
                $unapproved_comment_count = mysqli_num_rows($unapproved_comment_query);
            ?>
            <div class="row">
                                
                <script type="text/javascript">
                    google.load("visualization", "1.1", {packages:["bar"]});
                    google.setOnLoadCallback(drawChart);
                    function drawChart(){
                        var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count'],       
                            <?php                                   
                                $element_text = ['All Posts','Active Posts','Draft Posts', 'All Comments','Approved Comments','Unapproved Comments', 'Categories'];       
                                $element_count = [$post_count,$post_published_count, $post_draft_count, $comment_count,$comment_count - $unapproved_comment_count ,$unapproved_comment_count, $category_count];
                                for($i =0;$i < 7; $i++) {
                                    echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                                }                                                        
                            ?>        
                        ]);

                        const options = {
                            chart: {
                            title: '',
                            subtitle: '',
                            }
                        };
                        const chart = new google.charts.Bar(document.getElementById('columnchart_material'));
                        chart.draw(data, options);
                    }
                </script>                             
            <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>     
    <!-- /#page-wrapper -->
<div>
<!-- /#id-wrapper -->  
<?php include "includes/footer.php" ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>

<script>
    $(document).ready(function(){
        const pusher =   new Pusher('a202fba63a209863ab62', {
            cluster: 'us2',
            encrypted: true
        });
        const notificationChannel =  pusher.subscribe('notifications');
        notificationChannel.bind('new_user', function(notification){
            const message = notification.message;
            toastr.success(`${message} just registered`);
        });
    });
</script>

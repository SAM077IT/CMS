<?php include "includes/db.php" ?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/cms">CMS Front</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php
                    $query = "SELECT * FROM categories";
                    $selectAllCat = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_assoc($selectAllCat)){
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];

                        $pageName = basename($_SERVER['PHP_SELF']);
                        $category_class = '';
                        $registration_class = '';
                        $contact_class = '';
                        $login_class = '';
                        
                        if(isset($_GET["category"]) && $_GET["category"] == $cat_id){
                            $category_class = 'active';
                        }else if($pageName == 'registration.php'){
                            $registration_class = 'active';
    
                        }else if($pageName == 'contact.php'){
                            $contact_class = 'active';
    
                        }else if($pageName == 'login.php'){
                            $login_class = 'active';
                        }

                        echo "<li class = '$category_class'><a href='/cms/category/$cat_id'>{$cat_title}</a></li>";
                    }

                    ?>
                    <?php if(isLoggedIn()): ?>
                        <li>
                        <?php if(isAdmin()){ ?>
                            <a href="/cms/admin/">Admin</a>
                        <?php }else{ ?>
                            <a href="/cms/admin/dashboard.php">Admin</a>
                        <?php } ?>
                        </li>
                        <li>
                            <a href="/cms/includes/logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class = <?php echo $login_class;?> >
                            <a href="login">Login</a>
                        </li>
                        <li class = <?php echo $registration_class;?>>
                        <a href="registration">Registration</a>
                        </li>
                    <?php endif; ?>

                    <li class = <?php echo $contact_class;?>>
                        <a href="contact">Contact Us</a>
                    </li>

                    <?php
                    if(isset($_SESSION['user_role'])){
                        if(isset($_GET['p_id'])){
                            $the_post_id = $_GET['p_id'];
                            echo "<li><a href='admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
                        }
                    }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
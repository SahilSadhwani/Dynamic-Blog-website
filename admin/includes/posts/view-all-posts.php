<?php

spl_autoload_register(function($class_name){
    include "../classes/".$class_name. '.class.php';
});
include_once("../includes/constants.php");
if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 1;
}
$start = (ADMIN_POSTS_PER_PAGE*($page-1));
$end = ADMIN_POSTS_PER_PAGE;


?>

<div class="container">
    <div class="table-responsive">
       <table class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>post title</th>
                <th>category</th>
                <th>body</th>
                <th>tags</th>
                <th>date</th>
                <th>status</th>
                <th>image</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        
        <tbody>
           <?php
            $db = new Database();
            $conn = $db->getConnection();
            $posts = new Posts($conn);
            $categories = new Categories($conn);
            Session::start_session();
            $author_id = $_SESSION['user_id'];
            $allPosts = $posts->readAllPostsOfAuthor($author_id);
            $num_rows = count($allPosts);
            
            $pagePosts = $posts->readAllPostsOfAuthor($author_id,$start,$end);
            echo $start." ".$end;
            $baseurl = BASEURL;
            
            for($i=0; $i<count($pagePosts); $i++){
                $category_name = $categories->getCategoryName($pagePosts[$i]['post_category_id']);
                $image_path = $baseurl."images/".$pagePosts[$i]['post_image'];
                echo<<<POST
                <tr>
                    <td>[data]</td>
                    <td>[data]</td>
                    <td>[data]</td>
                </tr>
POST;
                <?php
            }
            ?>
        </tbody>
        </table>
    

</div>
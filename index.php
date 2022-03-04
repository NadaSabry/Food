<?php 
include_once 'connect.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" media="all" href="Menue style.css?<version=1"><!--?<version=1-->
        <title></title>
    </head>
    <body>
    <center><div class="title"> Menu </div></center>
    <center> <div class="back"> 
            <center><div class="categ">
                    <?php
                    $pre = $con->prepare("SELECT * FROM category");
                    $pre->execute();
                    $result = $pre->get_result();
                    while ($cate = $result->fetch_assoc()) {
                        ?>
                        <form method="Post">
                            <button class="bt1" type="submit" name="id" value="<?php echo htmlspecialchars($cate['ID']) ?>" method="POST"><?php echo htmlspecialchars($cate['Name']) ?> </button>
                        <?php } ?>
                    </form>

                </div></center>  
            <div class="all_item">
                <?php
                if (isset($_POST['id'])) {
                    $pre = $con->prepare("SELECT * FROM item where Category_ID=?");
                    $pre->bind_param("i", $_POST['id']);
                } else {
                    $pre = $con->prepare("SELECT * FROM item");
                }
                $pre->execute();
                $result = $pre->get_result();
                while ($item = $result->fetch_assoc()){
                    ?>
                    <div class="item">
                        <img src="image/<?php echo htmlspecialchars($item['Image']) ?>" alt="No image">
                        <h4><?php echo htmlspecialchars($item['Name']) ?>
                            <br>
                            $<?php echo htmlspecialchars($item['Price']);
                    echo '.00';
                    ?></h4>
                        
                        <!-- buttons -->
                        
                        <form method="Post" class="f1">
                            <button class="btn_item" type="submit" name="add" value="<?php echo htmlspecialchars($item['ID']) ?>" method="POST">Add To Cart </button>
                        </form>
                        <form method="Post" action="item.php" class="f1">
                            <button class="btn_item" type="submit" name="details" value="<?php echo htmlspecialchars($item['ID']) ?>" method="POST">show Details </button>
                        </form>
                        
                        </div><?php } ?>
                
                        <?php
                        if (isset($_POST['add'])){
                            $user=1;
                            $pre=$con->prepare("INSERT INTO cart(Item_ID,User_ID)VALUES(?,?)");
                            $pre->bind_param("ii",$_POST['add'],$user);
                            $pre->execute();
                        }?>
            </div>
        </div></center>
</body>
</html>

<?php 
include_once 'connect.php';
if(isset($_POST['details'])) {
            $n = $_POST['details'];
        }else if(isset($_POST['add'])){
            $n=$_POST['add'];
        }else if(isset($_POST['send'])){
            $n=$_POST['send'];
        }else if(isset($_POST['like'])){
            $n=$_POST['like'];
        }else {
            $n = '1';
        }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <link rel="stylesheet" type="text/css" media="all" href="Item style.css"><!--?<version=1">-->
        <script src="https://kit.fontawesome.com/f838843bb1.js" crossorigin="anonymous"></script>
       
         <?php        
        
            $user = 1;
            $pre = $con->prepare("Select * FROM item where ID=?");
            $pre->bind_param("i", $n);
            $pre->execute();
            $result = $pre->get_result();
            while ($item = $result->fetch_assoc()) {
        ?>

                <div class="all"> 
                    <center><div class="item">
        <!-- left side -->                    
                            <div class="left">
                                    <img class="main_img" src="image/<?php echo htmlspecialchars($item['Image']) ?>" alt="No image">
                
        <!-- Like button -->                   
                                    <div class="btnlike">
                                        <form  method="Post">
                                             <button id="love" class="like" type="submit" name="like" value="<?php echo htmlspecialchars($item['ID']) ?>" method="Post"><i class="fas fa-heart"></i> </button>
                                        </form> 
                                    <?php
                                          $pre = $con->prepare("SELECT * FROM `like` WHERE Item_ID = $n");
                                          $pre->execute();
                                          $result = $pre->get_result();
                                          $flag=0;
                                          while ($it = $result->fetch_assoc()){
                                              if($it['User_ID']==$user)$flag=1;
                                          }
                                          
                                        if(isset($_POST['like'])){
                                           if($flag==0){  
                                           $pre = $con->prepare("INSERT INTO `like`(`Item_ID`, `User_ID`) VALUES ('$n','$user')");
                                           $pre->execute();
                                           ?><script>
                                                let n = document.querySelector('#love');
                                                 n.style.color = 'red';
                                            </script><?php
                                           }
                                           else{ 
                                               $pre = $con->prepare("DELETE FROM `like` WHERE Item_ID = $n and User_ID=$user");
                                               $pre->execute();
                                               ?><script>
                                                let n = document.querySelector('#love');
                                                 n.style.color = 'black';
                                               </script><?php
                                           }
                                        }
                                        $cont=0;
                                        $pre = $con->prepare("SELECT * FROM `like` WHERE Item_ID = $n");
                                        $pre->execute();
                                        $result = $pre->get_result();
                                        $flag=0;
                                        while ($it = $result->fetch_assoc()){
                                              $cont+=1;
                                              if($it['User_ID']==$user)$flag=1;
                                        }
                                          if($flag){
                                              ?><script>
                                                let n = document.querySelector('#love');
                                                 n.style.color = 'red';
                                               </script><?php
                                          }
                                          
                                    ?>

                                        <P><?php echo $cont ?> likes </p>
                                </div>
                                                
        <!-- Add To Cart button -->  
                                    <form  class="add" method="Post">
                                        <button class="btnAdd" type="submit" name="add" value="<?php echo htmlspecialchars($item['ID']) ?>" method="POST">Add To Cart </button>
                                    </form>
                                    <?php
                                        $pre = $con->prepare("INSERT INTO cart(Item_ID,User_ID)VALUES(?,?)");
                                        $pre->bind_param("ii", $n, $user);
                                        $pre->execute();
                                    ?>
                                </div>
        <!-- End left side -->
        
        <!-- Right side -->
                            <div class="text">
                                <h1><?php echo htmlspecialchars($item['Name']) ?></h1><br>
                                <h2>Ingredients</h2>
                                <p><?php echo htmlspecialchars($item['Ingredients']) ?></p>
                                <hr>
                                <h2>Price</h2>
                                <h1 class="num">$<?php echo htmlspecialchars($item['Price']) ?>.00</h1>
                                
                                <div class="AddComment">
                                    <hr>
        <!-- Add Comment -->
                                    <h2>Add Comment</h2>
                                    <form method="Post">
                                        <input type="text" name="comment" placeholder="Add comment">
                                         <button class="send" type="submit" name="send" value="<?php echo htmlspecialchars($item['ID']) ?>" method="POST">Send <i class="fas fa-paper-plane"></i> </button>
                                    </form>
                                    <?php 
                                      if(isset($_POST['send'])){
                                          $com=$_POST['comment'];
                                          $pre = $con->prepare("INSERT INTO comment(Review,ItemI_ID ,User_ID)VALUES(?,?,?)");
                                          $pre->bind_param("sii",$com,$n,$user);
                                          $pre->execute();
                                      }
                                    ?>
                                </div>
                                
                                <br><br>
        <!-- display all comment -->                        
                                <div class="comment">
                                    <?php 
                                          $pre = $con->prepare("SELECT Review,FullName,c.TimeCreatedAt from user as u join comment as c on ItemI_ID=? and u.ID=c.User_ID");
                                          $pre->bind_param("i",$n);
                                          $pre->execute();
                                          $result = $pre->get_result();
                                          while ($item = $result->fetch_assoc()){     
                                    ?>
                                    <p>
                                        <span class="nam"><?php echo htmlspecialchars($item['FullName'])?> </span><br>
                                        <span class="t"><?php echo htmlspecialchars($item['TimeCreatedAt'])?></span><br>
                                        <span class="com"><?php echo htmlspecialchars($item['Review'])?></span>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
        <!-- End Right side -->
                     </div></center>
    <?php } ?>
        </div>
    <script>
       let n = document.querySelector('#love');
       n.addEventListener('click',() => n.style.color = 'red');
    </script>
    </body>
</html>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class='container' style="background-color:transparent;">
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Меню
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?php
                                            
                        $query=mysql_query('SELECT * FROM `menu` WHERE `admin`=0');
                        while($row=mysql_fetch_assoc($query)){
                            echo '<a class="dropdown-item" href="'.$row['link'].'">'.$row['name'].'</a>';
                        }
                        ?>
                    </div>
                </li>
                <?php 
            
            if($_SESSION['admin']==1){
                echo '<li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    админ-Меню
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    ';
                        $query=mysql_query('SELECT * FROM `menu` WHERE `admin`=1');
                        while($row=mysql_fetch_assoc($query)){
                            echo '<a class="dropdown-item" href="'.$row['link'].'">'.$row['name'].'</a>';
                        }
            echo '</div></li>';
            }
            
            
            
            
            ?>
            </ul>

            <?php
        
        if($_SESSION['id']){
            echo '<a class="prepod_fio" href="#">'.$_SESSION['fio'].'</a>';
        }
        
        ?>

        </div>
    </div>
</nav>

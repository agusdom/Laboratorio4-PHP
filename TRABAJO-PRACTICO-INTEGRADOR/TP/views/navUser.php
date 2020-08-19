<?php  //-----------------------------------------------------------------------------------?>
<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <style>
    .imgCarrusel{
    width:1366px;
    height:594px;
   } 
</style>
    <span class="navbar-text">
        <strong>TP FINAL</strong>
    </span>
    <div id="header">
    <!-- <ul class="navbar-nav ml-auto"> -->
    <ul class="nav">  
        
       
       <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Home/ShowUserHomeView">MENU PRINCIPAL</a>          
        </li>
        

        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Basket/ShowUserBasketListView">CARRITO DE COMPRAS</a>     
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Purchase/ShowUserPurchaseListView">HISTORIAL DE COMPRAS</a>     
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Home/ShowUserFilterListView">FILTRAR EVENTOS</a>     
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Logout/Index">Logout</a>
        </li>

    </ul>
    </div>   
</nav>




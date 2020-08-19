

<?php  //-----------------------------------------------------------------------------------?>
<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <span class="navbar-text">
        <strong>TP FINAL</strong>
    </span>
    <div id="header">
    <!-- <ul class="navbar-nav ml-auto"> -->
    <ul class="nav">  
        
        <li class="nav-item">  
            <a class="nav-link" href="#" >ARTISTAS</a>
            <ul class="navbar-nav ml-auto">   
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Artist/ShowAddArtistView">Agregar Artista</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Artist/ShowModifyArtistListView">Modificar Artista</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Artist/ShowListArtistView">Listar Artista</a>
                </li>   
            </ul>   
        </li>
       
        <li class="nav-item">
            <a class="nav-link" href="#">EVENTOS</a>
            <ul class="navbar-nav ml-auto">   
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Event/ShowAddEventView">Agregar Evento</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Event/ShowModifyEventListView">Modificar Evento</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Event/ShowListEventView">Listar Evento</a>
                </li>
            </ul>              
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">CATEGORIAS</a>
            <ul class="navbar-nav ml-auto">   
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Category/ShowAddCategoryView">Agregar Categoria</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Category/ShowModifyCategoryListView">Modificar Categoria</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Category/ShowListCategoryView">Listar Categoria</a>
                </li> 
            </ul>              
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">LUGARES</a>
            <ul class="navbar-nav ml-auto">   
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> PlaceEvent/ShowAddPlaceEventView">Agregar Lugar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> PlaceEvent/ShowModifyPlaceEventListView">Modificar Lugar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> PlaceEvent/ShowListPlaceEventView">Listar Lugar</a>
                </li>
            </ul>              
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">PLAZAS</a>
            <ul class="navbar-nav ml-auto">   
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> SeatType/ShowAddSeatTypeView">Agregar Plaza</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> SeatType/ShowModifySeatTypeListView">Modificar Plaza</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> SeatType/ShowListSeatTypeView">Listar Plaza</a>
                </li>
            </ul>              
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">CALENDARIO</a>
            <ul class="navbar-nav ml-auto">   
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Calendar/ShowAddCalendarView">Agregar Calendario</a>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Calendar/ShowModifyCalendarListView">Modificar Calendario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Calendar/ShowListCalendarView">Listar Calendario</a>
                </li>
            </ul>              
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">PLAZA x CALENDARIO</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> EventSeat/ShowAddEventSeatView">Agregar Plazas x Calendario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> EventSeat/ShowDeleteEventSeatCalendarView">Eliminar Plazas x Calendario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> EventSeat/ShowModifyEventSeatListView">Modificar Plazas x Calendario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT; ?> EventSeat/ShowListEventSeatView">Listar Plazas x Calendario</a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT; ?> SalesMovement/ShowSaleMovementMenuView">CONSULTAS</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?php echo FRONT_ROOT; ?> Logout/Index">Logout</a>
        </li>

    </ul>
    </div>   
</nav>




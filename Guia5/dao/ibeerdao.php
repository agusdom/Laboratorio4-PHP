<?php
    namespace DAO;

    use Models\Beer as Beer;
    
    interface IBeerDAO
    {
        function Add(Beer $beer);
        function GetAll();
        function GetByCode($beerCode);
        function Delete($beerCode);
    }
?>
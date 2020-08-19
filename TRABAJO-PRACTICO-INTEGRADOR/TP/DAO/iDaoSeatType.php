<?php
namespace Dao;

use Model\SeatType as SeatType;

interface IDaoSeatType
{
    function GetAll();
    function AddseatType(SeatType $seatType);
    function GetByseatTypeId($seatTypeId);
    function GetBySeatTypeName($typeName);
    function ModifyseatType($id, SeatType $seatTypeNew);
    function DeleteseatType($seatTypeId);
}

?>
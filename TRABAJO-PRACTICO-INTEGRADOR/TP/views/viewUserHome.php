<?php require_once(VIEWS_PATH . "navUser.php"); ?>
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
<ol class="carousel-indicators">
  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
</ol>
<div class="carousel-inner">
<?php 
if(isset($eventList))
{
  if(isset($this->eventSeatDao))
  {  
    $flag= true;
    foreach ($eventList as $key => $event)
    { 
      if($this->eventSeatDao->GetByEventId($event->getId()) != null)
      {//para que muestre solo los eventos que tienen eventSeat Relacionados
        if($flag)
        {
          ?>
          <div class="carousel-item active">
          <a href="<?php echo FRONT_ROOT . 'Home/DisplayEventSeatCalendars/' . $event->getId();?>"><img class="imgCarrusel" src="<?= $this->eventDao->GetAll()[$key]->getPhoto()->getPath();?>" alt="First slide" ></a>
        </div>
          <?php 
        }
        else
        { 
          ?>
          <div class="carousel-item ">
          <a href="<?php echo FRONT_ROOT . 'Home/DisplayEventSeatCalendars/' . $event->getId();?>"><img class="imgCarrusel" src="<?= $this->eventDao->GetAll()[$key]->getPhoto()->getPath();?>" alt="First slide" ></a>
          </div>
          <?php 
        }
        $flag= false;
      }
    }
    ?>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>

    <?php
  }
}

echo (isset($message)) ? $message : ""; ?>
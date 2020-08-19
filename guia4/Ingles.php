<?php
private $massage = 'Hello';
private $massage2 = 'Bye';

public function Greet(){
    echo '<h1 align="center" style="color:blue">' $this->massage</h1>
}

public function Dissmiss(){
    echo '<h1 align="center" style="color:blue">' $this->massage2</h1>
}

public function Other($othermassage){
    echo '<h1 align="center" style="color:blue">' $this->othermassage</h1>
}

?>
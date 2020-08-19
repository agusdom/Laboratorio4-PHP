<?php 
namespace Controllers;

use \Exception as Exception;
use Dao\daoBasketList as daoBasketList;
use Dao\DaoEventSeatPDO as DaoEventSeatPDO;
use Dao\DaoPurchasePDO as DaoPurchasePDO;
use Dao\DaoEventPDO as DaoEventPDO; 
use Dao\DaoUserPDO as DaoUserPDO;

use Model\Event as Event;
use Model\EventSeat as EventSeat;
use Model\Purchase as Purchase;
use Model\PurcaseRow as PurcaseRow;
use Model\User as User;

class ControllerPurchase
{
    private $purchaseDao;
    private $basketDao;
    private $eventDao;
    private $eventSeatDao;
    private $userDao;

    public function __construct()
    {

        $this->purchaseDao= new DaoPurchasePDO();
        $this->basketDao= new DaobasketList();
        $this->eventDao= new DaoEventPDO();
        $this->eventSeatDao= new DaoEventSeatPDO();
        $this->userDao= new DaoUserPDO();
       
    }


    public function ShowUserHomeView($message= null)
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $eventList= $this->eventDao->GetAll();
                require_once(VIEWS_PATH . "viewUserHome.php");
            }
            else
            {
                require_once(VIEWS_PATH . "viewLogin.php");
            }
        }
        catch(Exception $ex)
        {
            $eventList= $this->eventDao->GetAll();
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewUserHome.php");
        } 
    }   

    public function ShowUserBasketListView($message= null)
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $basketList= $this->basketDao->GetAll();
                require_once(VIEWS_PATH . "viewUserBasketList.php"); 
            }
            else
            {
                require_once(VIEWS_PATH . "viewLogin.php");
            }
        }
        catch(Exception $ex)
        {
            $eventList= $this->eventDao->GetAll();
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewUserHome.php");
        } 
    }
    
    public function ShowUserPurchaseListView($message= null)
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $userList= $_SESSION["userLogged"];
                $purchaseList= $this->purchaseDao->GetAll();
                require_once(VIEWS_PATH . "viewUserPurchaseList.php"); 
            }
            else
            {
                require_once(VIEWS_PATH . "viewLogin.php");
            }
        }
        catch(Exception $ex)
        {
            $eventList= $this->eventDao->GetAll();
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewUserHome.php");
        } 
    }

    public function ShowTiketView($purchaseRowId)
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                require_once(VIEWS_PATH . "viewUserticket.php"); 
            }
            else
            {
                require_once(VIEWS_PATH . "viewLogin.php");
            }
        }
        catch(Exception $ex)
        {
            $eventList= $this->eventDao->GetAll();
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewUserHome.php");
        } 
    }


    public function Add()
    {
        try
        {
            if(isset($_SESSION["userBasket"]))
            {
                $sendOk= false;
                $purchase= $this->basketDao->GetAll();
                if(count($purchase->getPurchaseRowList()) > 0)
                {
                    $purchaseRowIdArray= $this->purchaseDao->AddPurchase($purchase);

                    foreach($purchaseRowIdArray as $purchaseRowId)
                    {
                        $this->GenerateQR($purchaseRowId); //genera un codigo QR por cada una de las entradas cargadas
                        
                        $user= $purchase->getUser();
                        $this->GeneratePDF($purchaseRowId, $user); //genera archivo PDF
                        $sendOk= $this->SendMail($purchaseRowId, $user); // envia mail y retorna verdadero o falso dependiendo de si tuvo exito enviandolo 
                    }

                    foreach($purchase->getPurchaseRowList() as $purchaseRow)
                    {
                        $eventSeat= $purchaseRow->getEventSeat();
                        $quantity= $purchaseRow->getQuantity();
                        $eventSeat->setRemains($eventSeat->getRemains()-$quantity);

                        $this->eventSeatDao->ModifyRemain($eventSeat->getId(), $eventSeat);
                    }
                    $this->basketDao->DeletePurchase();
                    if($sendOk) //evalua si se envio el mail 
                    {
                        $message = 'Gracias por tu compra!!\n\n Te enviamos un correo con el ticket de tu compra';
                        echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    }
                    else
                    {
                        $message = 'Gracias por tu compra!! \n\n Hubo un error enviando tu ticket por correo, descargalo desde tu historial de compras';
                        echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    }
                    $this->ShowUserHomeView();
                }   
                else
                {
                    $message="agregue elementos al carrito antes de comprar";
                    $this->ShowUserBasketListView($message);
                }
                
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$ex.'");</script>';
           $this->ShowUserHomeView();
        }
    }

    public function Delete($purchaseId)
    {
        try
        {
            $message="";
            $contAnt= 0;
            $contPost= 0;

            if((isset($purchaseId)) && (!empty($purchaseId)))
            {
                $contAnt= count($this->purchaseDao->GetAll());
                
                $this->purchaseDao->DeletePurchase($purchaseId);

                $contPost= count($this->purchaseDao->GetAll());
                
                if($contAnt > $contPost)
                {
                    $message= "eliminado correctamente!!";
                }
                else
                {
                    $message= "error eliminado!!";
                }
            }
            else
            {
                $message= "parametros incorrectos, no se elimino el registro";
            }
            $this->ShowDeletePurchaseView($message);
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            $this->ShowUserHomeView();
        }
    }

    public function modifyList($id)
    {
        try
        {
        $oPurchase= $this->purchaseDao->GetByPurchaseId($id);
        
        if(isset($oPurchase))
        {
            $message="";
            $this->ShowModifyPurchaseView($oPurchase, $message);
        }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            $this->ShowUserHomeView();
        }
    }


    public function Modify($id, $date, $userId)
    {//$userName no lo uso pero lo tengo que poner, ya que el form me trae los input por orden
        //y si no lo pongo me confunde el $userId con el $userName 
        try
        {

            if((isset($date))&&(isset($userId)))
            {
                if((!empty($date))&&(!empty($userId)))
                {
                    $purchaseNew= new Purchase();
                    $purchaseNew->setId($id);  
                    $purchaseNew->setName($date);
                    $oUser= $this->userDao->GetByUserId($userId);
                
                    if((isset($oUser)) && (!empty($oUser)))
                    {
                        $purchaseNew->setUser($oUser);
                    }

                    $this->purchaseDao->ModifyPurchase($id, $purchaseNew);
                    $message= "se han modificado los cambios!!";
                    $this->ShowModifyPurchaseListView($message);
                }
                else
                {
                    $oPurchase= $this->purchaseDao->GetByPurchaseId($id);
            
                    if(isset($oPurchase))
                    {
                        $message= "algun parametro esta vacio";
                        $this->ShowModifyPurchaseView($oPurchase, $message);
                    }
                }
            }
            else
            {
                $oPurchase= $this->purchaseDao->GetByPurchaseId($id);
            
                if(isset($oPurchase))
                {
                    $message= "algun parametro no esta seteado";
                    $this->ShowModifyPurchaseView($oPurchase, $message);
                }
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            $this->ShowUserHomeView();
        }
    }

    public function GenerateQR($purchaseRowId)
    {  
        //Agregamos la libreria para genera códigos QR
        require_once(QR_PATH."qrlib.php");

        //Declaramos una carpeta temporal para guardar la imagenes generadas
        $dir = 'QRImages/';

        //Si no existe la carpeta la creamos
        if (!file_exists($dir))
            mkdir($dir);

        //Declaramos la ruta y nombre del archivo a generar
        $filename = $dir. $purchaseRowId.'.png';

        //Parametros de Condiguración
        $tamaño = 10; //Tamaño de Pixel
        $level = 'L'; //Precisión Baja
        $framSize = 1; //Tamaño en blanco
        $contenido = $purchaseRowId; //Texto

            //Enviamos los parametros a la Función para generar código QR
        \QRcode::png($contenido, $filename, $level, $tamaño, $framSize); //agregamos la barra invertida antes de la clase para no usar el use

            //Mostramos la imagen generada
        //echo '<img src="'.$dir.basename($filename).'" /><hr/>';    
    }

    public function GeneratePDF($purchaseRowId, $user)
    {
        require_once(PDF_PATH. "fpdf.php");
        
        $purchaseRow= $this->purchaseDao->GetPurchaseRowById($purchaseRowId);
        
        $eventSeat= $purchaseRow->getEventSeat();
        $calendar= $eventSeat->getCalendar();
        $event= $calendar->getEvent();
        $placeEvent= $calendar->getPlaceEvent();

        $border=0;
        $pdf= new \FPDF('L', 'mm', array(90, 210)); //agregamos la barra invertida antes de la clase para no usar el use
        $pdf->AddPage();
        $pdf->SetFont('arial', 'b', 15); // tipo letra, negrita, tamaño letra
        
        //CELL: largo, alto, contenido (texto), borde, salto de linea, alineacion (left L, right R, center C )
        $pdf->cell(25, 10, 'TICKET', 1, 0, 'C');
        $x= $pdf->GetX();
        $pdf->SetX($x+10);
        $pdf->cell(100, 10, $event->getName(), $border, 0, 'C');
        $pdf->image(ROOT."QRImages/".$purchaseRowId.".png", 150, 5, 30);
        $y= $pdf->Gety();
        $pdf->SetY($y+25);
        $pdf->cell(50, 10, $calendar->getDate(), $border , 0, 'L');
        $pdf->cell(100, 10, $placeEvent->getName(), $border, 1, 'L');
        $pdf->cell(100, 10, "Usuario: ". $user->getLastName()." ".$user->getName() , $border, 1, 'L');
        $pdf->cell(60, 10, 'Cant Entradas: 1', $border, 0, 'L');
        $pdf->cell(60, 10, "Importe: ".$purchaseRow->getPrice(), $border, 0, 'L');
        
        $pdf->Output('F', "pdf/".$purchaseRowId.".pdf");
   
    }

    public function SendMail($purchaseRowId, $user)
    {
        
        //require('PHPMailer/PHPMailerAutoload.php');
        require_once(EMAIL_PATH. "PHPMailerAutoload.php");
        
        $mail = new \PHPMailer();
        
        $mail->isSMTP();

        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            ));

        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        
        $mail->Username = 'ventaticketsoficial@gmail.com'; //Correo de donde enviaremos los correos
        $mail->Password = 'utn123456'; // Password de la cuenta de envío

        $mail->setFrom('ventaticketsoficial@gmail.com', 'ventas_ticket');
        $mail->addAddress($user->getEmail(), $user->getName()); //Correo receptor
        
        $attachmentFileName= $purchaseRowId.".pdf";
        $mail->addAttachment("pdf/".$attachmentFileName, "Ticket");
        
        $mail->Subject = 'Detalle de tu compra';
        $mail->Body    = 'le enviamos adjunto su ticket, muchas gracias por su compra';
        
        if($mail->send()) //en este if se controla Y SE ENVIA !! TAMBIEN EL CORREO
        {
            $sendOk= true;
            //echo 'Correo Enviado';
        }
        else
        {
            $sendOk= false;
            echo 'Error al enviar correo';
        }
        return $sendOk;
    }


}

?>
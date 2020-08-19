
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<hr>
<div class="container">
    <form action="<?php echo FRONT_ROOT; ?> Login/Login" method="post" >
        <table >
            <tr>
                <td colspan="2">LOGIN</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" id="" required></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" id="" required></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Ingresar"></td>
            </tr>
            <tr>
                <td colspan="2"><?php if(isset($message))echo $message; ?></td>
            </tr>
        </table>
    </form>
    </div> 
</body>
</html>
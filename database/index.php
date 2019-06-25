<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>仓储管理系统</title>
    <link rel="stylesheet" type="text/css" href="mystyle.css" />
    <script src="myScript.js"></script>
</head>
<body>
<h1>仓储管理系统</h1>
<form id="user" action="" method="POST">
    用户：
    <input id="name" type="text" name="user">
    <br />
    密码：
    <input id="password" type="password" name="password">
    <br /><br />
    管理人员
    <input type="radio" checked="checked" value="0" name="type" />
    采货人员
    <input type="radio" value="1" name="type" />
    <br />
    销售人员
    <input type="radio" value="2" name="type" />
    审核人员
    <input type="radio" value="3" name="type" />
    <br />
    <input type="submit" name="submit" value="登录" style="position: absolute;margin-top: 10px;margin-left: 40%;text-align:center;">
</form>
<p>made by Peizhong Qiu<br />May 25th, 2019 </p>

<?php
    if( $_POST['submit'] == "登录"){
        //echo "<script>alert('用户名为:". $_POST['user'] . "密码为:" . $_POST['password'] . "');</script>";
        
        
        include './connect.php';
        $server = new sql('LAPTOP-BF7H3R0J','admin','123456','last');echo 2 ;
        $sql = "select SPASSWORD from STAFF WHERE ID = ? AND STYPE = ? AND STATE = 1"; //sql语句写在这
        $param = array($_POST['user'],$_POST['type']);
        $result = $server->doQuery_2( $sql,$param); //查询返回的句柄
        $output = '';
        $mt = false;
        if ( ! is_string( $result )){
            while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
                echo $re['SPASSWORD'] ;
                //echo 1 ;
                if(rtrim($re['SPASSWORD']) == rtrim($_POST['password']))
                    $mt = true;
            }
        }else{
            echo $result;
        }
        $server->close();
        if($mt){
            switch($_POST['type']){
                case 0:
                    session_start();
                    $_SESSION["id"] = $_POST['user'];
                    header("Location:addAdmin.php");
                    break;
                case 1:
                    session_start();
                    $_SESSION["id"] = $_POST['user'];
                    header("Location:infoBuy.php");
                    break;
                case 2:
                    session_start();
                    $_SESSION["id"] = $_POST['user'];
                    header("Location:infoSale.php");
                    break;
                default:
                    session_start();
                    $_SESSION["id"] = $_POST['user'];
                    header("Location:infoRe.php");
                    break;
            }
        }
        else{
            echo "<script>alert('用户名或密码出错');</script>";
        }
    }
?>
     
</body>
</html>
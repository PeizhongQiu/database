<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>仓储管理系统</title>
    <link rel="stylesheet" type="text/css" href="myadminstyle.css" />
    <script src="myScript.js"></script>
    <style>
        #update2{
            margin-left: 45%;
        }
        form{
            position: absolute;
            margin-top: 50px;
            margin-left: 40%;
            width: 30%;
        }
    </style>
</head>
<body>
    <div class="title_line">
        <?php
            session_start();
            echo "<p id=\"welcome\">欢迎回来，".$_SESSION['id']."</p>";
        ?>
        <p id="title">仓储管理系统</p>
        <div class="dropdown">
            <button class="dropbtn">菜单</button>
                <div class="dropdown-content">
                <button id="add" onclick="add()">添加人员</button>
                <button id="delete" onclick="del()">删除人员</button>
                <button id="modify" onclick="modify()">修改人员</button>
                <button id="sear" onclick="sear()">查询人员</button>
                <button id="quit" onclick="out()">退出</button>
            </div>
        </div>
    </div> 
    <div class="form_input">
        <form id="user1" action="" method="POST">
            <fieldset>
                <legend>填写个人信息</legend>
                用户号码：
                <input id="uid" type="text" name="uid">
                <br />
                用户密码：
                <input id="password3" type="password" name="password">
                <br />
                确认密码：
                <input id="password4" type="password" name="password2">
                <br />
                <input id="update2" type="submit" value="删除" name="submit">
            </fieldset>
        </form>
        <?php
            if( $_POST['submit'] == "删除"){
                if(!preg_match("/^[ABSR][0-9]{5}$/",rtrim($_POST['uid']))){ 
                    echo "<script>alert('号码不匹配');</script>";
                    return;
                }
                if(rtrim($_POST['password'])!=rtrim($_POST['password2'])){
                    echo "<script>alert('确认密码和密码不匹配');</script>";
                    return;
                }
                
                include './connect.php';
                $server = new sql('LAPTOP-BF7H3R0J','admin','123456','last');
                $server->transaction();//开始事务
                $sql = "select SPASSWORD from STAFF WHERE ID = ? AND STATE = 1"; //sql语句写在这
                $param = array($_POST['uid']);
                $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                $mt = false;
                if ( ! is_string( $result )){
                    while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
                        echo $re['SPASSWORD'] ;
                        if(rtrim($re['SPASSWORD']) == rtrim($_POST['password']))
                            $mt = true;
                    }
                }else{
                    echo $result;
                    $server->rollback();
                    $server->close();
                    return ;
                }
                if(!$mt){
                    echo "<script>alert('用户名或密码出错');</script>";
                    $server->rollback();
                    $server->close();
                    return ;
                }
                $sql = "UPDATE STAFF SET STATE = 0 WHERE ID = ?"; //sql语句写在这
                $result = $server->doQuery_2( $sql,$param); //查询返回的句柄
                if ( ! is_string( $result ) && $result){
                    $server->commit();
                    echo "<script>alert('删除成功');</script>";
                }
                else{
                    die( print_r( sqlsrv_errors(), true));
                    echo $result;
                    echo "<script>alert('删除失败');</script>";
                    $server->rollback();
                }
                $server->close();
            }
        ?>  
    </div>
</body>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>仓储管理系统</title>
    <link rel="stylesheet" type="text/css" href="myadminstyle.css" />
    <script src="myScript.js"></script>
    <style>
        #update3{
            margin-left: 45%;
        }
        select{
            width:48%;
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
        <form id="user2" action="" method="POST">
            <fieldset>
                <legend>填写个人信息</legend>
                用户号码：
                <input id="uid2" type="text" name="uid">
                <br />
                用户姓名：
                <input id="name2" type="text" name="user">
                <br />
                用户旧密码：
                <input id="password5" type="password" name="password">
                <br />
                用户新密码：
                <input type="password" name="password2">
                <br />
                确认新密码：
                <input type="password" name="password3">
                <br />
                用户种类：
                <select id="select_type2" name="type">
                        <option value="0">管理人员</option>
                        <option value="1">采货人员</option>
                        <option value="2">销售人员</option>
                        <option value="3">审核人员</option>
                </select>
                <br />
                用户性别：男
                <input type="radio" checked="checked" value="0" name="sex"/>
                女
                <input type="radio" value="1" name="sex"/>
                <br />
                出生年月：
                <input id="birth2" type="date" name="birth2">
                <br />
                <input id="update3" type="submit" value="修改" name="submit">
            </fieldset>
        </form>
        <?php
            if( $_POST['submit'] == "修改"){
                if(!preg_match("/^[ABSR][0-9]{5}$/",rtrim($_POST['uid']))){ 
                    echo "<script>alert('号码不匹配');</script>";
                    return;
                }
                if(rtrim($_POST['password3'])!=rtrim($_POST['password2'])){
                    echo "<script>alert('确认密码和密码不匹配');</script>";
                    return;
                }
                
                include './connect.php';
                $server = new sql('LAPTOP-BF7H3R0J','admin','123456','last');
                $server->transaction();//开始事务
                $sql = "select * from STAFF WHERE ID = ? AND STATE = 1"; //sql语句写在这
                $param = array($_POST['uid']);
                $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                $mt = false;
                if ( ! is_string( $result ) && $result){
                    while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
                        //echo $re['SPASSWORD'] ;
                        if($_POST['user']=='')
                            $param = array(rtrim($re['SNAME']));
                        else $param = array(rtrim($_POST['user']));
                        if($_POST['password3']=='')
                            array_push($param,rtrim($re['SPASSWORD']));
                        else array_push($param,rtrim($_POST['password3']));
                        array_push($param,$_POST['type']);
                        array_push($param,$_POST['sex']);
                        if($_POST['birth2']=='')
                            array_push($param,$re['BIRTH']);   
                        else array_push($param,$_POST['birth2']);   
                        array_push($param,$re['ID']);   
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

                $sql = "UPDATE STAFF SET SNAME=?,SPASSWORD=?,STYPE=?,SEX=?,BIRTH=? WHERE ID = ?"; //sql语句写在这

                $result = $server->doQuery_2( $sql,$param); //查询返回的句柄
                if ( ! is_string( $result ) && $result){
                    $server->commit();
                    echo "<script>alert('修改成功');</script>";
                }
                else{
                    die( print_r( sqlsrv_errors(), true));
                    echo $result;
                    echo "<script>alert('修改失败');</script>";
                    $server->rollback();
                }
                $server->close();
            }
            
        ?>
    </div>
</body>
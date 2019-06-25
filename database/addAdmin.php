<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>仓储管理系统</title>
    <link rel="stylesheet" type="text/css" href="myadminstyle.css" />
    <script src="myScript.js"></script>
    <style>
        #update{
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
        <form id="user" action="" method="POST">
            <fieldset>
                <legend>填写个人信息</legend>
                用户姓名：
                <input id="name" type="text" name="user">
                <br />
                用户密码：
                <input id="password" type="password" name="password">
                <br />
                确认密码：
                <input id="password2" type="password" name="password2">
                <br />
                用户种类：
                <select id="select_type" name="type">
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
                <input id="birth" type="date" name="birth" />
                <br />
                <input id="update" type="submit" value="添加" name="submit">
            </fieldset>
        </form>
        
        <?php
            if( $_POST['submit'] == "添加"){
                if(rtrim($_POST['user'])==''){
                    echo "<script>alert('请输入姓名');</script>";
                    return;
                }
                if(rtrim($_POST['password'])!=rtrim($_POST['password2'])){
                    echo "<script>alert('确认密码和密码不匹配');</script>";
                    return;
                }
                
                include './connect.php';
                $server = new sql('LAPTOP-BF7H3R0J','admin','123456','last');
                $server->transaction();//开始事务
                $sql = "select COUNT(*) AS NUM from STAFF WHERE STYPE = '" . $_POST['type'] . "'"; //sql语句写在这
                $result = $server->doQuery( $sql ); //查询返回的句柄
                $num = 0;
                if ( ! is_string( $result )){
                    while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
                        $num = $re['NUM'] ;
                    }
                }else{
                    echo $result;
                    $server->rollback();
                    $server->close();
                    return ;
                }
                $work_num='';
                switch($_POST['type']){
                    case 0:
                        $work_num='A'.substr('00000'.$num,strlen('00000'.$num)-5);
                        //echo $work_num;
                        break;
                    case 1:
                        $work_num='B'.substr('00000'.$num,strlen('00000'.$num)-5);
                        //echo $work_num;
                        break;
                    case 2:
                        $work_num='S'.substr('00000'.$num,strlen('00000'.$num)-5);
                        //echo $work_num;
                        break;
                    default:
                        $work_num='R'.substr('00000'.$num,strlen('00000'.$num)-5);
                    // echo $work_num;
                        break;
                }
                $param=array($work_num,$_POST['user'],$_POST['type'],$_POST['password'],1,$_POST['sex'],$_POST['birth']);
                $sql = "INSERT INTO STAFF VALUES(?,?,?,?,?,?,?)"; //sql语句写在这
                $result = $server->doQuery_2( $sql,$param); //查询返回的句柄
                if ( ! is_string( $result ) && $result){
                    $server->commit();
                    echo "<script>alert('添加成功，你的账号为".$work_num."');</script>";
                }
                else{
                    die( print_r( sqlsrv_errors(), true));
                    echo $result;
                    echo "<script>alert('添加失败');</script>";
                    $server->rollback();
                }
                $server->close();
            }
        ?> 
    </div>
</body>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>仓储管理系统</title>
    <link rel="stylesheet" type="text/css" href="myadminstyle.css" />
    <script src="myScript.js"></script>
    <style>
        #user1,#user2,#user3{
            display: none;
        }
        #update,#update2,#update3,#search{
            margin-left: 45%;
        }
        select{
            width:48%;
        }
        table {
            display: none;
            border-collapse: collapse;
            position: absolute;
            margin-top: 50px;
            margin-left: 60%;
            width: 30%;
        }
        table, td, th {
            border: 1px solid black;
        }
        
        form{
            position: absolute;
            margin-top: 50px;
            margin-left: 40%;
            width: 30%;
        }
        #user3{
            position: absolute;
            margin-top: 50px;
            margin-left: 20%;
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
        <form id="user3" action="" method="POST">
            <fieldset>
                <legend>填写个人信息</legend>
                用户号码：
                <input id="uid3" type="text" name="uid">
                <br />
                用户姓名：
                <input id="name3" type="text" name="user">
                <br />
                用户种类：
                <select id="select_type3" name="type">
                        <option value="0">管理人员</option>
                        <option value="1">采货人员</option>
                        <option value="2">销售人员</option>
                        <option value="3">审核人员</option>
                        <option value="4">随便</option>
                </select>
                <br />
                用户性别：男
                <input type="radio" checked="checked" value="0" name="sex"/>
                女
                <input type="radio" value="1" name="sex"/>
                都行
                <input type="radio" value="2" name="sex"/>

                <br />
                起始年月：
                <input id="birth3" type="date" name="birth3">
                <br />
                终止年月：
                <input id="birth4" type="date" name="birth4">
                <br />
                <input id="search" type="submit" value="查找" name="submit" onclick="search()">
            </fieldset>
        </form>
        <table id="result">
            <tr>
                <th>用户号码</th>
                <th>用户名称</th>
                <th>用户状态</th>
                <th>用户种类</th>
                <th>用户性别</th>
                <th>出生年月</th>
            </tr>
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
                else if( $_POST['submit'] == "删除"){
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
                else if( $_POST['submit'] == "修改"){
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
                    if ( ! is_string( $result )){
                        while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
                            echo $re['SPASSWORD'] ;
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
                else if( $_POST['submit'] == "查找"){
                    if(rtrim($_POST['uid'])!=''&&!preg_match("/^[ABSR][0-9]{5}$/",rtrim($_POST['uid']))){ 
                        echo "<script>alert('号码不匹配');</script>";
                        return;
                    }
                    if($_POST['uid']=='')
                        $param = array('%');
                    else $param = array(rtrim($_POST['uid']));

                    if($_POST['user']=='')
                        array_push($param,'%');
                    else array_push($param,rtrim($_POST['user']));

                    if($_POST['type']==4)
                        array_push($param,'%');
                    else array_push($param,rtrim($_POST['type']));

                    if($_POST['sex']==2)
                        array_push($param,'%');
                    else array_push($param,rtrim($_POST['sex']));

                    if($_POST['birth3']=='')
                        array_push($param,'1900-01-01');   
                    else array_push($param,$_POST['birth3']);   
                    if($_POST['birth4']=='')
                        array_push($param,date("Y-m-d"));   
                    else array_push($param,$_POST['birth4']);  

                    include './connect.php';
                    $server = new sql('LAPTOP-BF7H3R0J','admin','123456','last');
                    $sql = "select * from STAFF WHERE ID like ? AND SNAME like ? AND STYPE LIKE ? AND SEX LIKE ? AND BIRTH BETWEEN ? AND ?"; //sql语句写在这
                    $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                    if ( ! is_string( $result )){
                        while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
            ?>
                        <tr>
                            <td><?php echo $re['ID'] ?></td>
                            <td><?php echo $re['SNAME'] ?></td>
                            <td><?php if($re['STATE']=='1') echo '在职';else echo '辞职' ?></td>
                            <td><?php if($re['STYPE']=='0') echo '管理人员';
                                    else if($re['STYPE']=='1') echo '采购人员';
                                    else if($re['STYPE']=='2') echo '销售人员';
                                    else if($re['STYPE']=='3') echo '审核人员'; ?> ?></td>
                            <td><?php if($re['SEX']=='1') echo '女';else echo '男' ?></td>
                            <td><?php echo $re['BIRTH'] ?></td>
                        </tr>
            <?php
                        }
                    }else{
                        echo $result;
                        $server->close();
                        return ;
                    }
                    
                    $server->close();
                    echo "<script type='text/javascript'>search();</script>";
                }
            ?>
        </table>
    
            
    </div>
</body>
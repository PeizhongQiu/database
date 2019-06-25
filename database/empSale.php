<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>仓储管理系统</title>
    <link rel="stylesheet" type="text/css" href="myadminstyle.css" />
    <script src="mySale.js"></script>
    <style>
        table {
            border-collapse: collapse;
            table-layout: fixed;
            text-align: center;
        }
        table, td, th {
            border: 1px solid black;
        }

        #saleProc,#saleTable{
            position: absolute;
            margin-top: 50px;
            width:40%;
            margin-left: 40%;
        }
        #saleProc,#saleSerch{
            position: absolute;
            margin-top: 50px;
            width:25%;
            margin-left: 20%;
        }
        #serchTable{
            position: absolute;
            width: 40%;
            margin-left: 50%;
            margin-top: 50px;
        }
        #saleEmp{
            position: absolute;
            width: 40%;
            margin-left: 40%;
            margin-top: 50px;
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
                <button id="info" onclick="info()">个人信息</button>
                <button id="inputTable" onclick="inputTable()">填写出货表</button>
                <button id="process" onclick="procSear()">进度查询</button>
                <button id="hist" onclick="hist()">历史记录</button>
                <button id="emp" onclick="emp()">填写缺货表</button>
                <button id="emp" onclick="empSer()">缺货表查询</button>
                <button id="quit" onclick="out()">退出</button>
            </div>
        </div>
    </div> 
    <div class="form_input">
        <form id="saleTable" action="" method="POST">
            <fieldset>
                <legend>填写缺货表</legend>
                填写日期：
                <input id="date" type="text" value="<?php echo date("Y-m-d"); ?>" readonly="readonly" name="date">
                <table id="buy" width=100% >
                    <tr>
                        <th width=10%>序号</th>
                        <th width=40%>名称</th>
                        <th width=10%>数量</th>
                        <th width=10%>操作</th>
                    </tr>
                    <?php
                        include './connect.php';
                        $server = new sql('LAPTOP-BF7H3R0J','sale','123456','last');
                        $sql = "select * from LOSS_NOT_SUB WHERE SID = '" . $_SESSION['id'] . "'"; //sql语句写在这
                        $result = $server->doQuery($sql); //查询返回的句柄
                        if ( ! is_string( $result ) && $result){
                            $num=1;
                            while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
                    ?>
                            <tr>
                                <td><?php echo $num ?></td>
                                <td><input name="<?php echo 'GID'.$num ?>" type="text" value="<?php echo $re['GID'] ?>" style="border:none;background-color:transparent; "></td>
                                <td><input name="<?php echo 'NUM'.$num ?>" type="text" value="<?php echo $re['NUM'] ?>" style="border:none;background-color:transparent; "></td>
                                <td><a onclick="del(this);">删除</a></td>
                            </tr>
                    <?php
                                $num=$num+1;
                            }
                        }else{
                            echo $result;
                        }
                        $server->close();
                    ?>
                </table>
                <input type="button" onClick="addRow();" style="font-size:16px;float: left;" value="+"/>
                <div style="margin-left: 35%;">
                    <input type="submit" style="font-size:16px;" value="保存" name="submit"/>
                    <input type="submit" style="font-size:16px; margin-left: 10%;" value="提交" name="submit"/>
                </div>
                <p><strong>提交前请仔细检查，一旦提交，只会将正确的信息上传</strong></p>
            </fieldset>
        </form>
        <?php 
            if( $_POST['submit'] == "保存"){
                $all= count($_POST)-2;
                $server = new sql('LAPTOP-BF7H3R0J','sale','123456','last');
                $server->transaction();
                $sql = "DELETE FROM LOSS_NOT_SUB WHERE SID = ? ";
                $param=array($_SESSION['id']);
                $result = $server->doQuery_2( $sql,$param);
                $mt=true;
                if ( !is_string( $result ) && $result){
                    //echo '删除成功';
                }
                else {
                    die( print_r( sqlsrv_errors(), true));
                    echo $result;
                    echo "<script>alert('删除失败');</script>";
                    $server->rollback();
                }
                for($i=1;$i<=$all/2;$i++){
                    //echo $_POST['GID'.$i];
                    //echo $_POST['NUM'.$i];
                    $param=array($_SESSION['id']);
                    array_push($param,$_POST['GID'.$i]);
                    if($_POST['GID'.$i]==''){
                        if($i==$all/2) $server->commit();
                        continue;
                    }
                    if(!preg_match("/^[G][0-9]{9}$/",rtrim($_POST['GID'.$i]))){ 
                        if($i==$all/2) $server->commit();
                        continue;
                    }
                    if(rtrim($_POST['NUM'.$i])=='')
                        array_push($param,0);
                    else if(!preg_match("/^[0-9]{1,9}$/",rtrim($_POST['NUM'.$i]))){
                        if($i==$all/2) $server->commit();
                        continue;
                    }
                    else array_push($param,$_POST['NUM'.$i]);
                    //var_dump($param);
                    $sql = "INSERT INTO LOSS_NOT_SUB VALUES(?,?,?)"; //sql语句写在这
                    $result = $server->doQuery_2( $sql,$param); //查询返回的句柄
                    if ( !is_string( $result ) && $result){
                        //echo "添加成功";
                        if($i==$all/2) $server->commit();
                    }
                    else{
                        die( print_r( sqlsrv_errors(), true));
                        echo $result;
                        $server->rollback();
                        $mt=false;
                        break;
                    }
                }
                $server->close();
                if($mt){
                    echo "<script>alert('添加成功');</script>";
                }
                else{
                    echo "<script>alert('添加失败');</script>";
                }
            }
            else if($_POST['submit'] == "提交"){
                $all= count($_POST)-2;
                
                $server = new sql('LAPTOP-BF7H3R0J','sale','123456','last');
                $server->transaction();

                $sql = "DELETE FROM LOSS_NOT_SUB WHERE SID = ? ";
                $param=array($_SESSION['id']);
                $result = $server->doQuery_2( $sql,$param);
                $mt=true;
                if ( !is_string( $result ) && $result){
                    //echo '删除成功';
                }
                else {
                    die( print_r( sqlsrv_errors(), true));
                    echo $result;
                    echo "<script>alert('删除失败');</script>";
                    $server->rollback();
                }

                $num=0;
                $sql = "SELECT COUNT(*) AS NUM FROM LOSS";
                $result = $server->doQuery( $sql);
                if ( !is_string( $result ) && $result){
                    while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
                        $num = $re['NUM'] ;
                    }
                }
                else {
                    die( print_r( sqlsrv_errors(), true));
                    echo $result;
                    echo "<script>alert('查找失败');</script>";
                    $server->rollback();
                }

                $eff=0;
                $good_num='L'.substr('0000000000'.$num,strlen('0000000000'.$num)-9);

                $param=array($good_num,$_SESSION['id'],date("Y-m-d"));
                $sql = "INSERT INTO LOSS (ID, SID, STIME, STATE) VALUES (?, ?,?,0)";
                $result = $server->doQuery_2( $sql,$param);
                if ( !is_string( $result ) && $result){
                    echo "<script>alert('添加成功1');</script>";
                }
                else {
                    die( print_r( sqlsrv_errors(), true));
                    echo $result;
                    echo "<script>alert('添加失败');</script>";
                    $server->rollback();
                }
                for($i=1;$i<=$all/2;$i++){
                    echo $_POST['GID'.$i];
                    echo $_POST['NUM'.$i];
                    $param=array($good_num);
                    array_push($param,$_POST['GID'.$i]);
                    if($_POST['GID'.$i]==''){
                        continue;
                    }
                    if(!preg_match("/^[G][0-9]{9}$/",rtrim($_POST['GID'.$i]))){ 
                        continue;
                    }
                    if(rtrim($_POST['NUM'.$i])=='' || rtrim($_POST['NUM'.$i])=='0')
                        continue;
                    else if(!preg_match("/^[0-9]{1,9}$/",rtrim($_POST['NUM'.$i]))){
                        continue;
                    }
                    else array_push($param,$_POST['NUM'.$i]);
                    var_dump($param);

                    $sql = "INSERT INTO LOSS_NUM VALUES(?,?,?)"; //sql语句写在这
                    $result = $server->doQuery_2( $sql,$param); //查询返回的句柄
                    if ( !is_string( $result ) && $result){
                        //echo "添加成功";
                        $eff++;
                    }
                    else{
                        die( print_r( sqlsrv_errors(), true));
                        echo $result;
                        $server->rollback();
                        break;
                    }
                }
                if($eff!=0){
                    $server->commit();
                }
                else{
                    $server->rollback();
                }
                $server->close();
            }
        ?>
    </div>
    
</body>
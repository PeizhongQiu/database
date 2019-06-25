<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>仓储管理系统</title>
    <link rel="stylesheet" type="text/css" href="myadminstyle.css" />
    <script src="myreview.js"></script>
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
                <button id="inputTable" onclick="inputTable()">未审核表</button>
                <button id="reviewTable" onclick="reviewTable()">填审核表</button>
                <button id="process" onclick="procSear()">历史查询</button>
                <button id="quit" onclick="out()">退出</button>
            </div>
        </div>
    </div> 
    <div class="form_input">
        <form id="user">
            <fieldset>
                <legend>个人信息</legend>
                <?php
                    include './connect.php';
                    $server = new sql('LAPTOP-BF7H3R0J','review','123456','last');
                    $sql = "select * from STAFF WHERE ID = '" . $_SESSION['id'] . "'"; //sql语句写在这
                    $result = $server->doQuery( $sql ); //查询返回的句柄
                    if ( ! is_string( $result )){
                        while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
                ?>
                    用户号码：
                    <input id="uid" type="text" value="<?php echo $re["ID"]?>" readonly="readonly">
                    <br />
                    用户姓名：
                    <input id="name" type="text" value="<?php echo $re["SNAME"]?>" readonly="readonly">
                    <br />
                    用户种类：
                    <input id="type" type="text" value="<?php if($re['STYPE']=='0') echo '管理人员';
                                    else if($re['STYPE']=='1') echo '采购人员';
                                    else if($re['STYPE']=='2') echo '销售人员';
                                    else if($re['STYPE']=='3') echo '审核人员';  ?>" readonly="readonly">
                    <br />
                    用户性别：
                    <input id="sex" type="text" value="<?php if($re['SEX']=='1') echo '女';else echo '男' ?>" readonly="readonly">
                    <br />
                    出生年月：
                    <input id="birth" type="text" value="<?php echo $re['BIRTH']->format("Y-m-d"); ?>" readonly="readonly">
                    <br />
                <?php
                        }
                    }else{
                        echo $result;
                        $server->rollback();
                        $server->close();
                        return ;
                    }
                    $server->close();    
                ?> 
            </fieldset>
            <strong>注意：个人信息不符者，请联系XXX-XXXX-XXXX进行信息修改!</strong>
        </form>
    </div>
</body>
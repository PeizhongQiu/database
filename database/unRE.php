<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>仓储管理系统</title>
    <link rel="stylesheet" type="text/css" href="myadminstyle.css" />
    <script src="myreview.js"></script>
    <style>
        table {
            border-collapse: collapse;
            table-layout: fixed;
            text-align: center;
        }
        table, td, th {
            border: 1px solid black;
        }
        #unreviewTable{
            position: absolute;
            width: 35%;
            margin-left: 10%;
            margin-top: 50px;
        }
        #serchTable{
            position: absolute;
            width: 40%;
            margin-left: 50%;
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
                <button id="inputTable" onclick="inputTable()">未审核表</button>
                <button id="reviewTable" onclick="reviewTable()">填审核表</button>
                <button id="process" onclick="procSear()">历史查询</button>
                <button id="quit" onclick="out()">退出</button>
            </div>
        </div>
    </div> 
    <div class="form_input">
        <form id="unreviewTable" action="" method="POST">
            <fieldset>
                <legend>未审核表</legend>
                <table id="unreview" width=100% >
                    <tr>
                        <th >编号</th>
                        <th >类别</th>
                        <th >负责人员</th>
                        <th  colspan="2">操作</th>
                    </tr>
                    <?php
                            include './connect.php';
                            $server = new sql('LAPTOP-BF7H3R0J','review','123456','last');
                            $sql = "select * from BUY WHERE RID IS NULL AND STATE = 0"; //sql语句写在这
                            $result = $server->doQuery( $sql ); //查询返回的句柄
                            $ord=1;
                            if ( ! is_string( $result )){
                                while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
                                    
                    ?>
                                <tr>
                                    <td ><input type="text" readonly="readonly" style="border:none;background-color:transparent;width:100px;" value="<?php echo $re['ID'] ?>" name="<?php echo 'bid'.$ord; ?>"/></td>
                                    <td >进货单</td>
                                    <td><?php echo $re['BID'] ?></td>
                                    <td ><input type="submit" style="font-size:16px;" value="查询" name="<?php echo 'submit'.$ord; ?>"/></td>
                                    <td ><input type="submit" style="font-size:16px;" value="审核" name="<?php echo 'submit'.$ord; ?>"/></td>
                                </tr>
                    <?php
                                    $ord++;
                                }
                            }else{
                                echo $result;
                            }
                            $sql = "select * from SALE WHERE RID IS NULL AND STATE = 0"; //sql语句写在这
                            $result = $server->doQuery( $sql ); //查询返回的句柄
                            if ( ! is_string( $result )){
                                while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
                    ?>
                                <tr>
                                    <td ><input type="text" readonly="readonly" style="border:none;background-color:transparent;width:100px;" value="<?php echo $re['ID'] ?>" name="<?php echo 'bid'.$ord; ?>"/></td>
                                    <td >出货单</td>
                                    <td><?php echo $re['SID'] ?></td>
                                    <td ><input type="submit" style="font-size:16px;" value="查询" name="<?php echo 'submit'.$ord; ?>"/></td>
                                    <td ><input type="submit" style="font-size:16px;" value="审核" name="<?php echo 'submit'.$ord; ?>"/></td>
                                </tr>
                    <?php
                                    $ord++;
                                }
                            }else{
                                echo $result;
                            }
                            $server->close();
                    ?>
                </table>
            </fieldset>
        </form>
        <table id="serchTable">
            <tr>
                <th>序号</th>
                <th>名称</th>
                <th>数量</th>
            </tr>
            <?php 
                $x=0;
                do{
                    $x++;
                    $y='submit'.$x;
                }while(!array_key_exists($y,$_POST) && $x<300);
                
                if( $_POST[$y] == "查询"){
                    //echo file_get_contents("php://input");
                    $server = new sql('LAPTOP-BF7H3R0J','review','123456','last');
                    $sql = "select * from BUY_NUM WHERE BID = ?"; //sql语句写在这
                    $param=array($_POST['bid'.$x]);
                    $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                    if ( ! is_string( $result ) && $result){
                        while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
            ?>
                            <tr>
                                <td><?php echo $re["BID"];?></td>
                                <td><?php echo $re["GID"];?></td>
                                <td><?php echo $re["NUM"];?></td>
                            </tr>
            <?php
                        }
                    }else{
                        echo $result;
                    }
                    $sql = "select * from SALE_NUM WHERE SID = ?"; //sql语句写在这
                    $param=array($_POST['bid'.$x]);
                    $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                    if ( ! is_string( $result ) && $result){
                        while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
            ?>
                            <tr>
                                <td><?php echo $re["SID"];?></td>
                                <td><?php echo $re["GID"];?></td>
                                <td><?php echo $re["NUM"];?></td>
                            </tr>
            <?php
                        }
                    }else{
                        echo $result;
                    }
                    $server->close();
                }
                else if($_POST[$y] == "审核"){
                    $server = new sql('LAPTOP-BF7H3R0J','review','123456','last');
                    $server->transaction();
                    $sql = "select * FROM BUY WHERE ID = ?"; //sql语句写在这
                    $param=array($_POST['bid'.$x]);
                    $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                    $num=0;
                    if ( ! is_string( $result ) && $result){
                        if(empty($re['RID'])) $num++;
                    }
                    else{
                        echo $result;
                        $server->rollback();
                    }
                    $sql = "select * FROM SALE WHERE ID = ?"; //sql语句写在这
                    $param=array($_POST['bid'.$x]);
                    $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄

                    if ( ! is_string( $result ) && $result){
                        if(empty($re['RID'])) $num++;
                    }
                    else{
                        echo $result;
                        $server->rollback();
                    }
                    if(num!=2){
                        $server->rollback();
                    }
                    $sql = "update BUY SET RID = ? WHERE ID = ?"; //sql语句写在这
                    $param=array($_SESSION['id'],$_POST['bid'.$x]);
                    $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄

                    if ( ! is_string( $result ) && $result){
                        //echo '加入审核';
                    }
                    else{
                        echo $result;
                        $server->rollback();
                    }
                    $sql = "update SALE SET RID = ? WHERE ID = ?"; //sql语句写在这
                    $param=array($_SESSION['id'],$_POST['bid'.$x]);
                    $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                    if ( ! is_string( $result ) && $result){
                        //echo '加入审核';
                    }
                    else{
                        echo $result;
                        $server->rollback();
                    }
                    $server->commit();
                    $server->close();
                }
            ?>
        </table>
    </div>
</body>
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
        #saleProc,#saleSerch{
            position: absolute;
            margin-top: 50px;
            width:50%;
            margin-left: 10%;
        }
        #serchTable{
            position: absolute;
            width: 30%;
            margin-left: 60%;
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
        <form id="saleProc" action="" method="POST">
            <fieldset>
                <legend>出货表进度</legend>
                <table id="procTable" width=100%>
                    <tr>
                        <th >序号</th><!--可点击，点击查询进货表内容-->
                        <th >进度</th><!--待审核，审核中，采购-->
                        <th>审核</th>
                        <th colspan="2">操作</th><!--当进度为采购时，按钮可点击-->
                    </tr>
                <?php

                        include './connect.php';
                        $server = new sql('LAPTOP-BF7H3R0J','sale','123456','last');
                        $sql = "select * from SALE WHERE SID = ? AND STATE = 0"; //sql语句写在这
                        $param=array($_SESSION['id']);
                        $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                        $ord=1;
                        if ( ! is_string( $result )){
                            while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
                ?>
                            <tr>
                                <td ><input readonly="readonly" type="text" style="font-size:16px;border:none;background-color:transparent;width:100px;" value="<?php echo $re['ID'] ?>" name="<?php echo 'bid'.$ord; ?>"/></td>
                                <td ><?php if(empty($re['RID'])) echo '待审核';
                                            else if(empty($re['RESULT'])) echo '审核中';
                                            else echo '待采购';?></td>
                                <td><?php if(empty($re['RESULT'])) echo '未完成';
                                            else echo '完成';?></td>
                                <td ><input type="submit" style="font-size:16px;" value="查询" name="<?php echo 'submit'.$ord; ?>"/></td>
                                <td ><input type="submit" style="font-size:16px;" value="完成" name="<?php echo 'submit'.$ord; ?>"/></td>
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
                    $server = new sql('LAPTOP-BF7H3R0J','sale','123456','last');
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
                else if($_POST[$y] == "完成"){
                    //echo 1;
                    $server = new sql('LAPTOP-BF7H3R0J','sale','123456','last');
                    $server->transaction();

                    $sql = "select * from SALE WHERE ID = ? AND STATE = 0"; //sql语句写在这
                    $param=array($_POST['bid'.$x]);
                    $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                    $mt=false;
                    if ( ! is_string( $result )){
                        while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
                            if(!empty($re['RESULT']))  $mt=true;
                            //echo 1;
                        }
                    }else{
                        echo $result;
                    }
                    if($mt){
                        $sql="select * from SALE_NUM where SID=?";
                        $param=array($_POST['bid'.$x]);
                        $result = $server->doQuery_2( $sql,$param );
                        while ( $re = sqlsrv_fetch_array ( $result )){
                            //更改货物数量
                            
                            $sql = "select * from GOODS where ID=? ";
                            $param=array($re['GID']);
                            $result2 = $server->doQuery_2( $sql,$param );
                            if ( ! is_string( $result2 ) && $result2){
                                $re2 = sqlsrv_fetch_array ( $result2 );
                                $num2=$re2['NUM']-$re['NUM'];
                                $sql = "update GOODS SET NUM = ? WHERE ID = ? ";
                                $param=array($num2,$re['GID']);
                                $result3 = $server->doQuery_2( $sql,$param );
                                if ( ! is_string( $result3 ) && $result3){
                                    //echo '修改成功';
                                }
                                else{
                                    echo $result3;
                                    $server->rollback();
                                }
                            }else{
                                echo $result2;
                                $server->rollback();
                            }
                        }
                       

                        //完成
                        $sql = "update SALE SET STATE = 1 WHERE ID = ? "; //sql语句写在这
                        $param=array($_POST['bid'.$x]);
                        $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                        if ( ! is_string( $result ) && $result){
                            echo "<script>alert('出货单完成');</script>";
                            $server->commit();
                        }else{
                            echo $result;
                            $server->rollback();
                        }
                    }
                    else{
                        //echo 2;
                        $server->rollback();
                    }
                    $server->close();
                }
            ?>
        </table>
    </div>
</body>
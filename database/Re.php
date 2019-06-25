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
        #review{
            position: absolute;
            width: 30%;
            margin-left: 15%;
            margin-top: 50px;
        }
        #ReviewInput{
            position: absolute;
            width: 45%;
            margin-left: 50%;
            margin-top: 50px;
        }
        #illustrate{
            width:100%;
            height: 50px;
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
        
        <form id='review' action="" method="POST">
            <fieldset>
                <legend>审核</legend>
                <table id="empTable" width=100%>
                    <tr>
                        <th >编号</th>
                        <th >类别</th>
                        <th >负责人员</th>
                    </tr>
                    <?php
                            include './connect.php';
                            $server = new sql('LAPTOP-BF7H3R0J','review','123456','last');
                            $sql = "select * from BUY WHERE RID = ? AND RESULT IS NULL"; //sql语句写在这
                            $param = array($_SESSION['id']);
                            $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                            $ord=1;
                            if ( ! is_string( $result ) && $result){
                                while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
                                    
                    ?>
                                <tr>
                                    <td ><input type="submit" style="width:100px;" value="<?php echo $re['ID'] ?>" name="submit"/></td>
                                    <td >进货单</td>
                                    <td><?php echo $re['BID'] ?></td>
                                </tr>
                    <?php
                                    $ord++;
                                }
                            }else{
                                echo $result;
                            }
                            $sql = "select * from SALE WHERE RID = ? AND RESULT IS NULL"; //sql语句写在这
                            $param = array($_SESSION['id']);
                            $result = $server->doQuery_2( $sql,$param );
                            if ( ! is_string( $result ) && $result){
                                while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
                    ?>
                                <tr>
                                    <td ><input type="submit" style="font-size:16px;" value="<?php echo $re['ID'] ?>" name="submit"/></td>
                                    <td >出货单</td>
                                    <td><?php echo $re['SID'] ?></td>
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
        <form id="ReviewInput" action="" method="POST">
            <fieldset>
                <legend>审核填写</legend>
                <table id="serchTable2" width=100% style="margin-bottom: 20px;">
                    <tr>
                        <th>序号</th>
                        <th>名称</th>
                        <th>数量</th>
                    </tr>
                    <?php
                        if($_POST['submit']=='提交'){
                            echo $_SESSION['bid_10'];
                            $server = new sql('LAPTOP-BF7H3R0J','review','123456','last');
                            $server->transaction();
                            $param = array(date("Y-m-d"));
                            array_push($param,$_POST['type']);
                            if($_POST['type']==0)
                                array_push($param,1);
                            else array_push($param,0);
                            array_push($param,$_POST['illu']);
                            array_push($param,$_SESSION['bid_10']);
                            $sql = "update BUY set RTIME=?,RESULT=?,STATE=?,SHUOMING=? WHERE ID = ?"; //sql语句写在这
                            $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                            if ( ! is_string( $result ) && $result){
                                //echo '修改成功';
                            }
                            else{
                                echo $result;
                                $server->rollback();
                            }
                            $sql = "update SALE set RTIME=?,RESULT=?,STATE=?,SHUOMING=? WHERE ID = ?"; //sql语句写在这
                            $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                            if ( ! is_string( $result ) && $result){
                                //echo '修改成功';
                                $server->commit();
                            }
                            else{
                                echo $result;
                                $server->rollback();
                            }
                            $server->close();
                        }
                        else {
                            //echo $_POST['submit'];
                            $_SESSION['bid_10']=$_POST['submit'];
                            //echo $_SESSION['bid_10'];
                            $id=$_POST['submit'];
                            $server = new sql('LAPTOP-BF7H3R0J','review','123456','last');
                            $sql = "select * from BUY_NUM WHERE BID = ?"; //sql语句写在这
                            $param = array($id);
                            $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                            if ( ! is_string( $result ) && $result){
                                while ( $re = sqlsrv_fetch_array ( $result )){
                        ?>
                            <tr>
                                <td ><?php echo $re['BID'] ?></td>
                                <td ><?php echo $re['GID'] ?></td>
                                <td ><?php echo $re['NUM'] ?></td>
                            </tr>
                        <?php 
                                }
                            }
                            else{
                                echo $result;
                            }
                            $sql = "select * from SALE_NUM WHERE SID = ?"; //sql语句写在这
                            $param = array($id);
                            $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                            if ( ! is_string( $result ) && $result){
                                while ( $re = sqlsrv_fetch_array ( $result )){
                        ?>
                            <tr>
                                <td ><?php echo $re['SID'] ?></td>
                                <td ><?php echo $re['GID'] ?></td>
                                <td ><?php echo $re['NUM'] ?></td>
                            </tr>
                        <?php 
                                }
                            }
                            else{
                                echo $result;
                            }
                            $server->close();
                        }
                    ?>
                </table>
                说明：
                <textarea id="illustrate" name = 'illu'></textarea>
                <br />
                审核结果：
                <select id="select_type" name = 'type'>
                    <option value="0">未通过</option>
                    <option value="1">通过</option>
                </select>
                <div style="margin-left: 35%;">
                    <!--<input type="button" style="font-size:16px;" value="保存"/>-->
                    <input type="submit" style="font-size:16px; margin-left: 10%;" value="提交" name = 'submit'/>
                </div>
            </fieldset>
        </form>
        
    </div>
</body>
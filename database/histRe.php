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
        #serchTable3{
            position: absolute;
            width: 40%;
            margin-left: 50%;
            margin-top: 50px;
        }
        
        #reviewSerch{
            position: absolute;
            margin-top: 50px;
            width:25%;
            margin-left: 20%;
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
        <form id='reviewSerch' action="" method="POST">
            <fieldset>
                <legend>表查询</legend>
                表编号：
                <input name="tid" type="text">
                <input id="tsearch" type="submit" value="查找" name="submit" style="font-size:16px; margin-left: 45%;">
            </fieldset>
        </form>
        <table id="serchTable3">
            <tr>
                <th>序号</th>
                <th>名称</th>
                <th>数量</th>
                <th>审核</th>
                <th>说明</th>
            </tr>
            <?php  
                if($_POST['submit']=='查找') {
                    include './connect.php';
                    $server = new sql('LAPTOP-BF7H3R0J','review','123456','last');
                    $sql = "select * from BUY,BUY_NUM WHERE BUY.ID=BUY_NUM.BID AND BUY.ID=?"; //sql语句写在这
                    $param = array($_POST['tid']);
                    $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                    if ( ! is_string( $result ) && $result){
                        while ( $re = sqlsrv_fetch_array ( $result )){
                ?>
                    <tr>
                        <td ><?php echo $re['BID'] ?></td>
                        <td ><?php echo $re['GID'] ?></td>
                        <td ><?php echo $re['NUM'] ?></td>
                        <td ><?php if($re['RESULT']==0) echo '审核失败'; else echo '审核成功'; ?></td>
                        <td ><?php echo $re['SHUOMING'] ?></td>
                    </tr>
                <?php 
                        }
                    }
                    else{
                        echo $result;
                    }
                    $sql = "select * from SALE,SALE_NUM WHERE SALE.ID=SALE_NUM.SID AND SALE.ID=?"; //sql语句写在这
                    $param = array($_POST['tid']);
                    $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                    if ( ! is_string( $result ) && $result){
                        while ( $re = sqlsrv_fetch_array ( $result )){
                ?>
                    <tr>
                        <td ><?php echo $re['SID'] ?></td>
                        <td ><?php echo $re['GID'] ?></td>
                        <td ><?php echo $re['NUM'] ?></td>
                        <td ><?php if($re['RESULT']==0) echo '审核失败'; else echo '审核成功'; ?></td>
                        <td ><?php echo $re['SHUOMING'] ?></td>
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
        
    </div>
</body>
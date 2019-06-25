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
        <form id='saleEmp'>
            <fieldset>
                <legend>缺货记录</legend>
                <table id="empTable" width=100%>
                    <tr>
                        <th width=20%>序号</th>
                        <th width=20%>名称</th>
                        <th width=10%>数量</th>
                        <th width=30%>时间</th>
                    </tr>
                <?php

                    include './connect.php';
                    $server = new sql('LAPTOP-BF7H3R0J','sale','123456','last');
                    $sql = "select * from LOSS,LOSS_NUM WHERE LOSS.ID=LOSS_NUM.LID AND STATE = 0 AND LOSS.SID= '".$_SESSION['id']."'"; //sql语句写在这
                    $result = $server->doQuery( $sql ); //查询返回的句柄
                    if ( ! is_string( $result )){
                        while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
            ?>
                        <tr>
                            <td><?php echo $re['ID'] ?></td>
                            <td><?php echo $re['GID'] ?></td>
                            <td><?php echo $re['NUM'] ?></td>
                            <td><?php echo $re['STIME']->format("Y-m-d"); ?></td>
                        </tr>
            <?php
                        }
                    }else{
                        echo $result;
                    }
                    $server->close();
                
            ?>
                </table>
            </fieldset>
        </form>
    </div>
</body>
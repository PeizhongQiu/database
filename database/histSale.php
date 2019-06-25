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
        <form id='saleSerch' action="" method="POST">
            <fieldset>
                <legend>出货表查询</legend>
                出货表ID：
                <input id="tid" type="text" name="bid">
                <br />
                审核结果：
                <select id="select_type3" name="type">
                        <option value="1">审核通过</option>
                        <option value="0">审核不通过</option>
                        <option value="2">随便</option>
                </select>
                
                <input id="tsearch" type="submit" value="查找" style="font-size:16px; margin-left: 45%;" name='submit'>
            </fieldset>
        </form>
        <table id="serchTable">
            <tr>
                <th>序号</th>
                <th>名称</th>
                <th>数量</th>
                <th>审核</th>
                <th>说明</th>
            </tr>
            <?php
                if( $_POST['submit'] == "查找"){
                    //echo 1;
                    //echo file_get_contents("php://input");
                    if(rtrim($_POST['bid'])!=''&&!preg_match("/^[B][0-9]{9}$/",rtrim($_POST['bid']))){ 
                        echo "<script>alert('号码不匹配');</script>";
                        return;
                    }
                    if($_POST['bid']=='')
                        $param = array('%');
                    else $param = array(rtrim($_POST['bid']));
                    
                    array_push($param,$_SESSION['id']);

                    if($_POST['type']==2)
                        array_push($param,'%');
                    else array_push($param,rtrim($_POST['type']));

                    include './connect.php';
                    $server = new sql('LAPTOP-BF7H3R0J','sale','123456','last');
                    $sql = "select * from SALE,SALE_NUM WHERE SALE.ID=SALE_NUM.SID AND SALE.ID like ? AND SALE.SID like ? AND RESULT LIKE ?"; //sql语句写在这
                    $result = $server->doQuery_2( $sql,$param ); //查询返回的句柄
                    if ( ! is_string( $result ) && $result){
                        while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
                            //echo 2;
            ?>
                        <tr>
                            <td width=15%><?php echo $re['ID'] ?></td>
                            <td width=15%><?php echo $re['GID'] ?></td>
                            <td width=15%><?php echo $re['NUM'] ?></td>
                            <td width=10%><?php if($re['RESULT']=='1') echo '通过';else echo '不通过' ?></td>
                            <td width=25%><?php echo $re['SHUOMING']; ?></td>
                        </tr>
            <?php
                        }
                    }else{
                        echo $result;
                    }
                    $server->close();
                }
            ?>
        </table>
    </div>
</body>
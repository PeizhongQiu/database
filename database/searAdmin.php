<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>仓储管理系统</title>
    <link rel="stylesheet" type="text/css" href="myadminstyle.css" />
    <script src="myScript.js"></script>
    <style>
        #search{
            margin-left: 45%;
        }
        select{
            width:48%;
        }
        table {
            border-collapse: collapse;
            position: absolute;
            margin-top: 50px;
            margin-left: 50%;
            width: 30%;
            text-align:center;
        }
        table, td, th {
            border: 1px solid black;
        }
        
        form{
            position: absolute;
            margin-top: 50px;
            margin-left: 50%;
            width: 45%;
        }
        #user3{
            position: absolute;
            margin-top: 50px;
            margin-left: 20%;
            width: 25%;
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
                <input id="search" type="submit" value="查找" name="submit">
            </fieldset>
        </form>
        <table id="result" >
            <tr>
                <th width=15%>号码</th>
                <th width=15%>名称</th>
                <th width=15%>状态</th>
                <th width=20%>种类</th>
                <th width=10%>性别</th>
                <th width=25%>出生年月</th>
            </tr>
            <?php
                if( $_POST['submit'] == "查找"){
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
                            <td width=15%><?php echo $re['ID'] ?></td>
                            <td width=15%><?php echo $re['SNAME'] ?></td>
                            <td width=15%><?php if($re['STATE']=='1') echo '在职';else echo '辞职' ?></td>
                            <td width=20%><?php if($re['STYPE']=='0') echo '管理人员';
                                    else if($re['STYPE']=='1') echo '采购人员';
                                    else if($re['STYPE']=='2') echo '销售人员';
                                    else if($re['STYPE']=='3') echo '审核人员';  ?></td>
                            <td width=10%><?php if($re['SEX']=='1') echo '女';else echo '男' ?></td>
                            <td width=25%><?php echo $re['BIRTH']->format("Y-m-d"); ?></td>
                        </tr>
            <?php
                        }
                    }else{
                        echo $result;
                        $server->close();
                        return ;
                    }
                    
                    $server->close();
                }
            ?>
        </table>
    </div>
</body>
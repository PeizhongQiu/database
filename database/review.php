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
        #unreviewTable,#serchTable,#review,#ReviewInput,#reviewSerch,#serchTable3{
            display: none;
        }
        #unreviewTable{
            position: absolute;
            width: 25%;
            margin-left: 20%;
            margin-top: 50px;
        }
        #serchTable,#serchTable3{
            position: absolute;
            width: 40%;
            margin-left: 50%;
            margin-top: 50px;
        }
        #review{
            position: absolute;
            width: 20%;
            margin-left: 20%;
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
        <form id="user">
            <fieldset>
                <legend>个人信息</legend>
                用户号码：
                <input id="uid" type="text">
                <br />
                用户姓名：
                <input id="name" type="text">
                <br />
                用户种类：
                <input id="type" type="text">
                <br />
                用户性别：
                <input id="sex" type="text">
                <br />
                出生年月：
                <input id="birth" type="text">
                <br />
            </fieldset>
            <strong>注意：个人信息不符者，请联系XXX-XXXX-XXXX进行信息修改!</strong>
        </form>
        <form id="unreviewTable">
            <fieldset>
                <legend>未审核表</legend>
                <table id="unreview" width=100% >
                    <tr>
                        <th width=20%>编号</th>
                        <th width=20%>类别</th>
                        <th width=40%>负责人员</th>
                        <th width=20%>操作</th>
                    </tr>
                </table>
            </fieldset>
        </form>
        <table id="serchTable">
            <tr>
                <th>序号</th>
                <th>名称</th>
                <th>单位</th>
                <th>数量</th>
                <th>单价</th>
            </tr>
        </table>
        <form id='review'>
            <fieldset>
                <legend>审核</legend>
                <table id="empTable" width=100%>
                    <tr>
                        <th width=20%>编号</th>
                        <th width=20%>类别</th>
                        <th width=60%>负责人员</th>
                    </tr>
                </table>
            </fieldset>
            
        </form>
        <form id="ReviewInput">
            <fieldset>
                <legend>审核填写</legend>
                <table id="serchTable2" width=100% style="margin-bottom: 20px;">
                    <tr>
                        <th>序号</th>
                        <th>名称</th>
                        <th>单位</th>
                        <th>数量</th>
                        <th>单价</th>
                    </tr>
                </table>
                说明：
                <textarea id="illustrate"></textarea>
                <br />
                审核结果：
                <select id="select_type">
                    <option value="0">未通过</option>
                    <option value="1">通过</option>
                </select>
                <div style="margin-left: 35%;">
                    <input type="button" style="font-size:16px;" value="保存"/>
                    <input type="button" style="font-size:16px; margin-left: 10%;" value="提交"/>
                </div>
            </fieldset>
        </form>
        
        <form id='reviewSerch'>
            <fieldset>
                <legend>表查询</legend>
                表编号：
                <input id="tid" type="text">
                <input id="tsearch" type="button" value="查找" onclick="tsearch()" style="font-size:16px; margin-left: 45%;">
            </fieldset>
        </form>
        <table id="serchTable3">
            <tr>
                <th>序号</th>
                <th>名称</th>
                <th>单位</th>
                <th>数量</th>
                <th>单价</th>
                <th>审核</th>
                <th>说明</th>
            </tr>
        </table>
        
    </div>
</body>
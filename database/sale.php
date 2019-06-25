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
        #serchTable,#saleTable,#saleProc,#saleSerch,#saleEmp{
            display: none;
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
        <form id="saleTable">
            <fieldset>
                <legend>填写出货表</legend>
                填写日期：
                <input id="date" type="text">
                <table id="sale" width=100% >
                    <tr>
                        <th width=10%>序号</th>
                        <th width=40%>名称</th>
                        <th width=10%>单位</th>
                        <th width=10%>数量</th>
                        <th width=10%>单价</th>
                        <th width=10%>操作</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td><span contenteditable="true"></span></td>
                        <td><span contenteditable="true"></span></td>
                        <td><span contenteditable="true"></span></td>
                        <td><span contenteditable="true"></span></td>
                        <td><a onclick="del(this);">删除</a></td>
                    </tr>
                </table>
                <input type="button" onClick="addRow();" style="font-size:16px;float: left;" value="+"/>
                <div style="margin-left: 35%;">
                    <input type="button" style="font-size:16px;" value="保存"/>
                    <input type="button" style="font-size:16px; margin-left: 10%;" value="提交"/>
                </div>
            </fieldset>
        </form>
        <form id="saleProc">
            <fieldset>
                <legend>出货表进度</legend>
                <table id="procTable" width=100%>
                    <tr>
                        <th width=40%>序号</th><!--可点击，点击查询进货表内容-->
                        <th width=40%>进度</th><!--待审核，审核中，采购-->
                        <th width=20%>操作</th><!--当进度为采购时，按钮可点击-->
                    </tr>
                </table>
            </fieldset>
        </form>
        
        <form id='saleSerch'>
            <fieldset>
                <legend>出货表查询</legend>
                出货表ID：
                <input id="tid" type="text">
                <br />
                <input id="tsearch" type="button" value="查找" onclick="tsearch()" style="font-size:16px; margin-left: 45%;">
            </fieldset>
        </form>
        <table id="serchTable">
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
        <form id='saleEmp'>
            <fieldset>
                <legend>缺货登记</legend>
                填写日期：
                <input id="date" type="text">
                <table id="empTable" width=100%>
                    <tr>
                        <th width=10%>序号</th>
                        <th width=40%>名称</th>
                        <th width=10%>单位</th>
                        <th width=10%>数量</th>
                        <th width=10%>单价</th>
                        <th width=10%>操作</th><!--当状态为未处理时，可以点击进行处理-->
                    </tr>
                    <tr>
                        <td>1</td>
                        <td><span contenteditable="true"></span></td>
                        <td><span contenteditable="true"></span></td>
                        <td><span contenteditable="true"></span></td>
                        <td><span contenteditable="true"></span></td>
                        <td><a onclick="del(this);">删除</a></td>
                    </tr>
                </table>
                <input type="button" onClick="addRow2();" style="font-size:16px;float: left;" value="+"/>
                <div style="margin-left: 35%;">
                    <input type="button" style="font-size:16px;" value="保存"/>
                    <input type="button" style="font-size:16px; margin-left: 10%;" value="提交"/>
                </div>
            </fieldset>
        </form>
    </div>
</body>
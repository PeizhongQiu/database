function info(){
    window.location.href="infoSale.php";
}

function inputTable(){
    window.location.href="inputSale.php";
}

function procSear(){
    window.location.href="procSale.php";
}

function hist(){
    window.location.href="histSale.php";
}

function emp(){
    window.location.href="empSale.php";
}

function empSer(){
    window.location.href="empSale2.php";
}


function addRow(){
    var oTable = document.getElementById("buy");
    var tBodies = oTable.tBodies;
    var tbody = tBodies[0];
    var tr = tbody.insertRow(tbody.rows.length);
    var td_1 = tr.insertCell(0);
    td_1.innerHTML = tbody.rows.length-1;
    var td_2 = tr.insertCell(1);
    td_2.innerHTML = "<input name='GID"+(tbody.rows.length-1)+"' type='text' style='border:none;background-color:transparent;'>";
    var td_3 = tr.insertCell(2);
    td_3.innerHTML = "<input name='NUM"+(tbody.rows.length-1)+"' type='text' style='border:none;background-color:transparent;'>";
    var td_6 = tr.insertCell(3);
    td_6.innerHTML = "<a onclick=\"del(this);\">删除</a>";
}
function del(obj)
{
    var tr=obj.parentNode.parentNode;
    tr.parentNode.removeChild(tr);
    var oTable = document.getElementById("buy");
    var tBodies = oTable.tBodies;
    var tbody = tBodies[0];
    for(var i=1;i<tbody.rows.length;i++){  
        tbody.rows[i].cells[0].innerHTML=i;
    }  
    var list=document.getElementsByTagName("input");
    for(var i=1;i<list.length;i++){
        if(i%2){
            list[i].name="GID"+(i+1)/2;
        }
        else list[i].name="NUM"+(i/2);
        
    }
}

function out(){
    window.location.href="index.php";
}
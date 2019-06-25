<?php
    class sql{
        private $serverName = "LAPTOP-BF7H3R0J"; //数据库服务器地址
        private $connectionInfo = array("UID"=>"sa", "PWD"=>"123456", "Database"=>'last');
        public $sql = "SELECT Name FROM Master..SysDatabases ORDER BY Name"; //默认的sql语句
        public $result;
        public $conn = '';
        public $param = array();
        public function __construct( $name ='' , $user ='' , $pwd ='' ,$db = '' ){
            if( $name ){
                $this->serverName = $name;
            }
            if( $user ){
                $this->connectionInfo['UID'] = $user;
            }
            if( $pwd ){
                $this->connectionInfo['PWD'] = $pwd;
            }
            if( $db ){
                $this->connectionInfo['Database'] = $db;
            }
            //connect to sqlserver
            if( !$this->conn ){
                //echo 3 ;
                $this->conn = sqlsrv_connect( $this->serverName, $this->connectionInfo)
                or die( sqlsrv_errors() );
            }
        }
        public function doQuery( $sql ){
            if(!$this->conn){
                return " sorry ,can't to link server" ;
            }
            if( $sql ){
                $this->sql = $sql ;
            }
            $this->result = sqlsrv_query($this->conn,$this->sql) ;
            return $this->result;
        }

        public function doQuery_2( $sql,$param){
            if(!$this->conn){
                return " sorry ,can't to link server" ;
            }
            if( $sql ){
                $this->sql = $sql ;
            }
            if( $param ){
                $this->param = $param ;
            }
            $this->result = sqlsrv_query($this->conn,$this->sql,$this->param) ;
            return $this->result;
        }
        
        public function close(){
            if($this->conn){
                sqlsrv_close ( $this->conn ) ;
            }
        }

        public function transaction(){
            if (sqlsrv_begin_transaction($this->conn) === false) {
                die(print_r(sqlsrv_errors(), true));
            }
        }
        
        public function commit(){
            if($this->conn){
                sqlsrv_commit($this->conn);
            }
        }
        
        public function rollback(){
            if($this->conn){
                sqlsrv_rollback($this->conn);
            }
        }
    }
    
    /*$server = new sql('LAPTOP-BF7H3R0J','admin','123456','last');
    $sql = "select ID from STAFF "; //sql语句写在这
    $result = $server->doQuery( $sql ); //查询返回的句柄
    $output = '';
    if ( ! is_string( $result )){
        while ( $re = sqlsrv_fetch_array ( $result )){ //sqlsrv_fetch_array 通过查询结果句柄获取查询结果
        //$output[] = $re; //打印查询结果
            var_dump( $re ) ;
        }
    }else{
        echo $result;
    }
    $server->close();*/
?>
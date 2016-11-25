<?php
header("Content-type:text/html;charset=utf-8");

//打印数据库的一张表
class showTable
{
    private $conn;
    private $host = 'localhost';
    private $username = 'root';
    private $psd = 'root';
    private $db;
    private $table;
    

    // 连接数据库
    public function __construct()
    {
        $this -> conn = mysql_connect($this->host,$this->username,$this->psd) or die(mysql_error());
        echo "connect succcessfully<br/>";
        mysql_query("set names utf8") or die('set names failuer');
        

    }

    // 获取表格数据
    public function show($db = 'sw',$table = 'sw_user')
    {
        $this->db = $db;
        $this->table = $table;
        mysql_query("use $this->db") or die("use $this->db failuer");
        $res = $this->getRes();
        // var_dump($res);
        
        $colArr = array();
        // 获取表格列名
        while($field = mysql_fetch_field($res))
        {
            $colArr[] = $field->name;
        }
        // print_r($colArr);


        $valArr = array();
        while ($row = mysql_fetch_row($res)) {
            $valArr[] = $row;
        }
          
        // print_r($valArr);
        
        $this->printTable($colArr,$valArr);//打印表格



    }
    // 打印表格
    function printTable($col,$val)
    {
        
        echo "<h4>数据库 $this->db 表 $this->table 数据展示</h4>";
        echo "<table border='1'>";
        echo "<tr>";
        foreach ($col as  $value) {
            echo "<td>",$value,"</td>";
        }
        echo "</tr>";

        foreach ($val as  $value) {
            echo "<tr>";
            foreach ($value as $v) {
               echo "<td>",$v,"</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

    }

    //查询结果
    function getRes()
    {
        $sql = "select * from $this->table";
        $res = mysql_query($sql);
        if(!$res)
        {
            var_dump($res);
            die("getRes failuer");
        }
        return $res;
    }


}

$link = new showTable();

if($_GET)
{
   if(isset($_GET['table']))
   {
        if(isset($_GET['db']))
        {
            $db = $_GET['db'];
            $table = $_GET['table'];
            $link->show($db,$table);
            break;
        }
        else
        {
            $table = $_GET['table'];
            $link->show('sw',$table);
        }
   }
   else
   {
        echo "输入格式错误";
   }

 } 
else
{
     $link->show();
}

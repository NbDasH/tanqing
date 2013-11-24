<?php
	class db{
		
		private $mysqli;
		private $host = 'localhost';
		private $user = 'root';
		private $pass = '';
		private $database = 'tq_post';
		
		public function __construct(){
			$this->mysqli = new MySQLi($this->host,$this->user,$this->pass,$this->database);
			$this->query('set names utf8');
		}
		
		public function query($sql){
			return $this->mysqli->query($sql);
		}
		
		public function fetch($result){
			$data = array();
			if($result){
				while($row = mysqli_fetch_assoc($result)){
					$data[] = $row;
				}
			}
			return $data;
		}
		
		private function get_where($where){
			$sql_where = '';
			if(!empty($where)){
				$sql_where = ' WHERE ';
				if(is_array($where)){
					foreach($where as $k=>$v){
						if(is_array($v)){
							$sql_where .= " `$v[0]` $v[1] '$v[2]' and ";
						}else{
							$sql_where .= " `$k` = '$v' and ";
						}
					}
					$sql_where = substr($sql_where,0,-4);
				}else{
					$sql_where .= $where;
				}
			}
			return $sql_where;
		}
		
		public function select($table,$where=NULL,$other=NULL,$select=NULL,$join=NULL){
			$select = $select ? $select : '*';
			$sql_where = $this->get_where($where);
			$sql = "SELECT $select FROM `$table` $join $sql_where $other";
			$result = $this->query($sql);
			return $this->fetch($result);
		}
		
		public function insert($table,$data){
			$sql_k = '';
			$sql_v = '';
			foreach($data as $k => $v){
				$sql_k .= " `$k` ,";
				$sql_v .= " '$v' ,";
			}
			$sql_k = substr($sql_k,0,-1);
			$sql_v = substr($sql_v,0,-1);
			$sql = "INSERT INTO `$table` ($sql_k) VALUES ($sql_v)";
			$this->query($sql);
		}
		
		public function update($table,$data,$where){
			$sql_where = $this->get_where($where);
			$sql_data = '';
			foreach($data as $k=>$v){
				$sql_data .= " `$k`='$v' ,";
			}
			$sql_data = substr($sql_data,0,-1);
			$sql = "UPDATE `$table` SET $sql_data $sql_where";
			$this->query($sql);
		}
		
		public function del($table,$where){
			$sql_where = $this->get_where($where);
			$sql = "DELETE FROM `$table` $sql_where";
			$this->query($sql);
		}
		
		public function insert_id(){
			return $this->mysqli->insert_id;
		}
	}
?>
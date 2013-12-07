<?php
	class page{
		private $all_row_nm;
		private $limit_nm;
		private $url;
		private $page;
		private $max_page;
		
		private $page_start_nm;
		private $page_end_nm;
		
		function __construct($all_row_nm,$limit_nm,$url,$page=NULL){
			$this->all_row_nm = $all_row_nm;
			$this->limit_nm = $limit_nm;
	
			$this->max_page = ceil($all_row_nm/$limit_nm);
			$this->url = $url;
			$this->page = intval($page) < 1 ? 1 : intval($page);
			$this->page = $this->page > $this->max_page ? $this->max_page : $this->page;
		}
		
		function set_page_se($nm){
			if($this->max_page <= $nm*2 + 1){
				$start = 1;
				$end = $this->max_page;
			}elseif($this->page - $nm <= 1){
				$start = 1;
				$end = $nm*2 + 1;
			}elseif($this->page + $nm >= $this->max_page){
				$start = $this->max_page - $nm*2;
				$end = $this->max_page;
			}else{
				$start = $this->page - $nm;
				$end = $this->page + $nm;
			}
			
			$this->page_start_nm = $start;
			$this->page_end_nm = $end;
			
		}
		
		function get_page_url($page){
			
			$url_arr = explode('?',$this->url);
			
			$data = '';
			
			if(count($url_arr) > 1){
				$params = explode('&',$url_arr[1]);
				foreach($params as $v){
					if(!empty($v)){
						$data .= $v.'&';
					}
				}
			}
			
			$url = $url_arr[0].'?'.$data.'page='.$page;
			
			return $url;
		}
		
		function get_mid_link(){
			$prev = '<span><a href="'.$this->get_page_url($this->page-1).'">上一页</a></span>';
			$next = '<span><a href="'.$this->get_page_url($this->page+1).'">下一页</a></span>';
			$mid = '';
			for($i=$this->page_start_nm;$i<= $this->page_end_nm;$i++){
				if($i != $this->page){
					$mid .= '<span><a href="'.$this->get_page_url($i).'">'.$i.'</a></span>';
				}else{
					$mid .= '<span class="grey">'.$i.'</span>';
				}
			}
			
			return $prev.$mid.$next;
		}
		
		function get_page($nm = NULL){
			$nm = $nm ? $nm : 3;
			$this->set_page_se($nm);
			
			$mid = $this->get_mid_link();
			
			$first=$end=NULL;
			if($this->max_page > $nm*2 + 1){
				$first = '<span><a href="'.$this->get_page_url(1).'">第一页</a></span>';
				$end = '<span><a href="'.$this->get_page_url($this->max_page).'">最后一页</a></span>';
			}
			
			return $first.$mid.$end;
			
		}
		
		function get_limit_start(){
			return ($this->page-1)*$this->limit_nm;	
		}
		
			
	}
?>
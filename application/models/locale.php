<?php  if (!defined('BASEPATH')) exit('No direct script access allowed.');
 
	class News_model extends Model {
		function News_model(){
			parent::Model();
 
			$this->fields = explode(',', 'post_id,main_id,title,body,post_date');
			$this->table = 'news';
			$this->key = 'post_id';
			$this->order = 'post_date desc';
 
			$this->reset();
		}
 
		function reset(){
			foreach($this->fields as $field){
				$this->$field = null;
			}
		}
 
		function select(){
			$result = false;
 
			foreach($this->fields as $field){
				if($this->$field){
					$this->db->where($field, $this->$field);
				}
			}
 
			$this->db->order_by($this->order);
			$query = $this->db->get($this->table);
 
			if($this->post_id){
				$result = $query->row();
			} else{
				$result = $query->result();
			}
 
			return $result;
		}
 
		function update(){
			$result = false;
 
			foreach($this->fields as $field){
				$entry[$field] = $this->$field;
			}
 
			if($this->post_id){
				$this->db->where($this->key, $this->post_id);
				$this->db->update($this->table, $entry);
			} else{
				$this->db->insert($this->table, $entry);
			}
 
			return $result;
		}
 
		function insert(){
			return $this->update();
		}
 
		function delete(){
			if($this->post_id){
				$this->db->where($this->key, $this->post_id);
				$this->db->delete($this->table);
			}
		}
	}
?>
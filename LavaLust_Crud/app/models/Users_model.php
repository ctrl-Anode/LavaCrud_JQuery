<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Users_model extends Model {
	public function read(){
        return $this->db->table('aza_users')->get_all();
    }
    public function create($aza_last_name, $aza_first_name, $aza_email, $aza_gender, $aza_address){
        $userdata = array(
            'aza_last_name' => $aza_last_name, 'aza_first_name' => $aza_first_name, 'aza_email' => $aza_email, 'aza_gender' => $aza_gender, 'aza_address' => $aza_address 
        );
        return $this->db->table('aza_users')->insert($userdata);
    }
    public function get_one($id){
        $result = $this->db->table('aza_users')->where('id', $id)->get();
        if ($result === false || empty($result)) {
            return false;
        }
        return $result;
    }
    public function update($aza_last_name, $aza_first_name, $aza_email, $aza_gender, $aza_address, $id){
        $userdata = array(
            'aza_last_name' => $aza_last_name, 
            'aza_first_name' => $aza_first_name, 
            'aza_email' => $aza_email, 
            'aza_gender' => $aza_gender, 
            'aza_address' => $aza_address 
        );
        // First check if user exists
        $user = $this->db->table('aza_users')->where('id', $id)->get();
        if (!$user) {
            return false;
        }
        return $this->db->table('aza_users')->where('id', $id)->update($userdata);
    }
    public function delete($id){
        return $this->db->table('aza_users')->where('id', $id)->delete();
    }
}
?>
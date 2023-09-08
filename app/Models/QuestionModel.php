<?php
namespace App\Models;
use CodeIgniter\Model;


class QuestionModel extends Model
{
   protected $table = 'question';
   protected $allowedFields = ['category','quest','descp','review','rating','status','added_on'];

   public function assets_added_data($data)
{
     $db      = \Config\Database::connect();
     $this->db->table("candidate")->insert($data);
     $insertId = $db->insertID();
     return $insertId;
}

public function candidate_show()
{
    return $this->db->table("candidate")->get()->getResultArray();
}


}
?>

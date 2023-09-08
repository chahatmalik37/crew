<?php
namespace App\Controllers;
use App\Models\QuestionModel;
use App\Controllers\BaseController;

class Question extends BaseController
{

    private $db;
  
    public function __construct()
    {
        $this->db = db_connect();
    }
    public function index()
    {
        $model = new QuestionModel();
        $show['question'] = $model->findAll();
        $show['candidate_show']= $model->candidate_show();
        

        // echo "<pre>";
        // print_r($show); exit;
        // echo view('include/header');
        echo view('question',$show);
        // echo view('include/footer');

    }



    public function insert()
    {
        // echo "hiii";
        $data = [
                
                'category'=> $this->request->getVar('category'),
                'quest'=> $this->request->getVar('asset_name'),
                // 'descp'=> $this->request->getVar('asset_desc'),
                // 'date'=> $this->request->getVar('date'),
                'descp'=> $this->request->getVar('value'),
                // 'reminder'=> $this->request->getVar('reminder'),
               
                ];
        $model = new QuestionModel();
        // $model->insert($data);
        $res = $model->insert($data);
        // $asset_id = $model->getInsertID(); 
         
         if($res){
            // $data1 = [
            //     'asset_id'=> $asset_id,
            //     'am_add'=> $this->request->getVar('value'),
            //     'date_add'=> $this->request->getVar('date'),
            //      ];
            // $model = new QuestionModel();
            // $res1 = $model->assets_added_data($data1);
        return redirect()->to(base_url('Question'));   
        
        }
    }

    public function edit($id){
        $model = new AssetsModel();
        $data['company'] = $model->findAll();
        $data['row'] =$model->where('id',$id)->first();
        // echo view('include/header');
        echo view('edit_company',$data);
        // echo view('include/footer');
    }

    public function update(){
        // echo "<pre>";
        // print_r($_POST); exit;
        $model = new QuestionModel();
        $id = $this->request->getVar('id_edit');
        $data =['category'=> $this->request->getVar('category_edit'),
                'quest'=> $this->request->getVar('question_edit'),
                'descp'=> $this->request->getVar('value_edit'),
                ];
        $model->update($id,$data);
        return redirect()->to(base_url('Question'));   
    }

    public function delete(){
        $model = new QuestionModel();
        $id = $this->request->getVar('del_db_id');
       $res = $model->where('id',$id)->delete();
            return json_encode($res);

        // return redirect()->to(base_url('Question'));   
    }

     

     

        public function pass_check(){
            $enter = $this->request->getVar("enter");
            $usersTable = $this->db->table("password_check");
            $usersTable->select("*");
            $usersTable->where('pass', $enter);
            $query = $usersTable->get()->getResultArray();
            // $assets_n = $this->db->query('SELECT id,asset_name,category from assets where category = '.$country_id)->getResultArray();
           
            return json_encode($query);
        }

        public function addvalue(){
            

            // print_r($_POST); exit;
           
            $data = [
               
                
                'date'=> $this->request->getVar('month_date'),
                'reference'=> $this->request->getVar('reference'),
                'mobile'=> $this->request->getVar('mobile'),
                'candidate_name'=> $this->request->getVar('candidate_name'),
                'email'=> $this->request->getVar('email'),
                'quest_c'=> $this->request->getVar('asset_cat'),
                'question'=> $this->request->getVar('asset_n'),
                'remark'=> $this->request->getVar('remark'),
                'rating'=> $this->request->getVar('rating'),
                 ];
            $model = new QuestionModel();
            $res = $model->assets_added_data($data);
             if($res){
              return redirect()->to(base_url('Question'));
            }

            
            // Array ( [asset_cat] => yrstyyr [asset_n] => agf [added_amount] => 7000 [month_date] => 2022-09-30 )
        }

        

        public function interview(){
            //   echo "<pre>";
            //   print_r($_POST); exit;
              $data = [
               
                'date'=> $this->request->getVar('review_1'),
                'reference'=> $this->request->getVar('review_2'),
                'candidate_name'=> $this->request->getVar('review_3'),
                'mobile'=> $this->request->getVar('review_4'),
                'email'=> $this->request->getVar('review_5'),
                'location'=> $this->request->getVar('review_6'),
               
                 ];
            $model = new QuestionModel();
            $res = $model->assets_added_data($data);

              $model = new QuestionModel();
              $query = $model->findAll();
                $count = count($query);
              

              for ($i=1; $i <= $count ; $i++) { 
                  $data=[
                    'user_id'=> $res,
                    'ques_id'=> $this->request->getVar('question_'.$i),
                    'review'=> $this->request->getVar('review_'.$i),
                    'rating'=> $this->request->getVar('rating_'.$i),
                    'sample'=> $this->request->getVar('sample_'.$i),
                    'cat_ques'=> $this->request->getVar('category_'.$i),
                  ];

                 $query = $this->db->table("interview")->insert($data);
              }

              return redirect()->to(base_url('Question'));

        }

        public function get_detail($id){
            // echo "hii";
            $builder = $this->db->table("interview");
            $builder->select('interview.*');
            // $builder->join('candidate', 'interview.user_id = candidate.id', "left");
            // $builder->join('question', 'interview.ques_id = question.id', "left"); 
            $builder->where('interview.user_id',$id);
            $query['user_detail'] = $builder->get()->getResultArray();
    
            // echo view('include/header');
            echo view('can_detail',$query);
            // echo view('include/footer');

        }
        
        public function search_data(){
        // echo "<pre>";
        // print_r($_POST); exit;
        $search_text = $this->request->getVar("search_text");
        $usersTable = $this->db->table("interview");
        $usersTable->select("*");
        $usersTable->like('review', $search_text);
        $query['search'] = $usersTable->get()->getResultArray();
        // echo "<pre>";
        //  print_r($query);
        // return redirect()->to('Question');
        // echo view('include/header');
        echo view('question_search',$query);
        // echo view('include/footer');
           

     }
     
     public function get_id(){
           $data = [
                'review'=> $this->request->getVar('remark'),
                'ques_id'=> $this->request->getVar('quest'),
                'user_id'=> $this->request->getVar('user_id'),
                ];
            $sales_get = $this->db->table("interview");
            $sales_get->where($data);
            $query = $sales_get->get()->getResultArray();  
           echo json_encode($query);
        }

        public function delete_review() {
          $id = $this->request->getVar('del_db_id');  
          $review_del = $this->db->table("interview");
          $review_del->where('id', $id);
          $res = $review_del->delete();

            return json_encode($res);
        }

        public function edit_review(){
            // echo "<pre>";
            //   print_r($_POST); exit;
            // echo $this->request->getVar('id'); 
            // exit;
            $user_id =$this->request->getVar('user_id'); 
            $data = [
                'cat_ques'=> $this->request->getVar('category_edit'),
                'ques_id'=> $this->request->getVar('question_edit'),
                'review'=> $this->request->getVar('remarks_edit'),
                'rating'=> $this->request->getVar('rating_edit'),
            ];

            $id = $this->request->getVar('id_edit');

            $val_update = $this->db->table("interview");
            $val_update->set($data);
            $val_update->where('id', $id);
            $res = $val_update->update();
            
            return redirect()->to(base_url('Question/get_detail/' . $user_id));
        }

}
?>
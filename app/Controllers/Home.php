<?php


namespace App\Controllers;


use App\Models\Cake;
use App\Models\User;

class Home extends BaseController{
    public $session;

    function __construct(){
        $this->session = \Config\Services::session();
    }

    public function view(){
        if ($this->session->has('user')){
            
            $user = (new User())->where('apikey', $this->session->get('user'))->findAll()[0];

            return view('home', $user);
        }else{
            return redirect()->route('auth');
        }
        
    }
    public function auth(){
        if ($this->session->has('user')){
            return redirect()->route('');
        }else{
            return view('auth');
        }
        
    }

    public function singlecake($id){

        $model = new Cake();
        $data = $model->find($id);    
        if (!empty($data)){
            $data = [
                'id' =>  $id
            ];
            return view('cakeview', $data);
        }else{
            echo 'Not found';
        }


        
        return view('cakeview', $data);

    }
    public function singlecakeedit($id){
        $model = new Cake();
        $data = $model->find($id);    
        if (!empty($data)){
            $data['access_type'] = 'edit';
            return view('cakeedit', $data);
        }else{
            echo 'Not found';
        }
    }
    public function singlecakecreate(){  
        return view('cakeedit', ['access_type'=>'create']);
    }
}

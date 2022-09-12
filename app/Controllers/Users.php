<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\User;

class Users extends ResourceController
{
    use ResponseTrait;
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index(){
        $model = new User();
        $data = $model->findAll();
        return $this->respond($data);
    }

    private function filter($data, $disallowed){
        $allowed = array();
        foreach ($data as $key => $value) {
            if (!in_array($key, $disallowed)){
                $allowed[$key] = $data[$key];
            }
        }
        return $allowed;

    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null){
        $model = new User();
        $data = $model->find($id);

        if (empty($data)){
            return $this->failNotFound('User not found in the DB');
        }else{
            return $this->respond($data);
        }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create(){
        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]',
            'password'=> 'required|min_length[3]',
        ];

        if ($this->validate($rules)){
            $data = [
                'username' => $this->request->getVar('username'),
                'password' => hash('ripemd160', $this->request->getVar('password')),
                'apikey' => hash('ripemd160', $this->request->getVar('password').$this->request->getVar('username')),
            ];
            
            $model = new User();
                
            if (!empty($model->where('username', $data['username'])->findAll())){
                return json_encode([
                    'error'=> 'Username Already Exists',
                ]);
            }
            $model->save($data);
            

            $session = \Config\Services::session();
            $session->set('user', $data['apikey']);

            $data = $this->filter($data, ['apikey', 'password']);

            return $this->respondCreated($data);
        }else{
            return $this->respondCreated([
                'error'=> 'inappropriate'
            ]);
        }
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function validateuser(){
        
        $model = new User();

        $user = $model->where('username', $data['username'])->where('password', hash('ripemd160', $this->request->getVar('password')));
            
        if (empty($user)){
            return $this->respondCreated([
                'error'=> 'Username does not exists',
            ]);
        }
        $session->set('user', $user[0]['apikey']);
        return $this->respondCreated([
            'message'=>'ok',
            'apikey'=>$user[0]['apikey']
        ]);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function validateuserapi(){

        $model = new User();
        $user = $model->where('apikey', $this->request->getVar('apikey'))->findAll();
            
        if (empty($user)){
            return $this->respondCreated([
                'message'=> 'Api key does not match any key',
            ]);
        }
        return $this->respondCreated([
            'message'=>'ok',
            'apikey'=>$user[0]['apikey']
        ]);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }


    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function findwhere(){

        $key = $this->request->getVar('key');
        $val = $this->request->getVar('value');

        $model = new User();
        $data = $model->where($key, $val)->findAll();
        if (empty($data)){
            return $this->failNotFound('User not found in the store');
        }else{
            return $data;
        }
    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function findlike(){
        $key = $this->request->getVar('key');
        $search = $this->request->getVar('search');

        $model = new User();
        $data = $model->like($key, $search)->findAll();
        if (empty($data)){
            return $this->failNotFound('User not found in the store');
        }else{
            return $data;
        }
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null){
        $model = new User();
        $data = $model->find($id);

        if (empty($data)){
            return $this->failNotFound('User not found in the store');
        }

        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]',
            'password'=> 'required|min_length[3]',
        ];

        if ($this->validate($rules)){
            $data = [
                'username' => $this->request->getVar('username'),
                'password' => $this->request->getVar('password'),
            ];
            $model = new User();

            if (!empty($model->where('username', $data['username']))){
                return json_encode([
                    'error'=> 'Username Already Exists',
                ]);
            }
            
            $model->update($id, $data);
            
            return $this->respondCreated($data);
        }else{
            return $this->respondCreated([
                'error'=> 'Inappropriate Data'
            ]);
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null){
        $model = new User();
        $data = $model->find($id);

        if (empty($data)){
            return $this->failNotFound('User not found in the DB');
        }

        $model->delete($id);
    }
}

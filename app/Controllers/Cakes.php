<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Cake;
use App\Models\User;

class Cakes extends ResourceController
{
    private $session;
    function __construct(){
        $this->session = \Config\Services::session();
    }


    use ResponseTrait;
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index(){
        $model = new Cake();
        $data = $model->orderBy('name', 'asc')->findAll();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null){
        $model = new Cake();
        $data = $model->find($id);

        if (empty($data)){
            return $this->failNotFound('Cake not found in the store');
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
            'name' => 'required',
            'price' => 'required',
            'recipe' => 'required',
            'type' => 'required',
        ];

        if ($this->validate($rules)){

            
            $users = new User();
           
            $user = $users->where('apikey', $this->session->get('user'))->findAll();
            $maker = $user[0]['username'];
            $data = [
                'name' => $this->request->getVar('name'),
                'maker' => $maker,
                'price' => $this->request->getVar('price'),
                'recipe' => $this->request->getVar('recipe'),
                'type' => $this->request->getVar('type'),
            ];



            $model = new Cake();
            $model->save($data);
            
            return $this->respondCreated($data);
        }else{
            return $this->respondCreated([
                'error'=> 'inappropriate'
            ]);
        }
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
        $model = new Cake();
        $data = $model->where($key, $val)->findAll();
        if (empty($data)){
            return $this->failNotFound('User not found in the store');
        }else{
            return $this->respond($data);
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
        
        $model = new Cake();
        $data = $model->like($key, $search)->findAll();
        if (empty($data)){
            return $this->respond([
                'error'=>'No match found'
            ]);
        }else{
            return  $this->respond($data);
        }
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null){
        $model = new Cake();
        $data = $model->find($id);

        if (empty($data)){
            return $this->failNotFound('Cake not found in the store');
        }

        $rules = [
            'name' => 'required',
            'price' => 'required',
            'recipe' => 'required',
            'type' => 'required',
        ];

        if ($this->validate($rules)){
            $data = [
                'name' => $this->request->getVar('name'),
                'price' => $this->request->getVar('price'),
                'recipe' => $this->request->getVar('recipe'),
                'type' => $this->request->getVar('type'),
            ];
            $model = new Cake();
            $model->update($id, $data);
            
            return $this->respondCreated($data);
        }else{
            return $this->respondCreated([
                'error'=> 'inappropriate Data'
            ]);
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null){
        $model = new Cake();
        $data = $model->find($id);

        if (empty($data)){
            return $this->failNotFound('Cake not found in the store');
        }
        $model->delete($id);
        return $this->respondCreated([
            'message'=> 'Cake Deleted'
        ]);
    }
}

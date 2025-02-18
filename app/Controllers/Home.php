<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $db, $user, $id, $session;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->user = $this->db->table('user');
    }
    public function index()
    {
        if (session('login') != "") {
            header("Location:" . base_url('dashboard'));
            exit;
        } else {
            echo view('login');
        }
    }
    public function login()
    {
        $input = $this->request->getVar();
        $user = $this->user->getWhere(['email' => $input['email']])->getRow();
        if ($user) {
            if (password_verify($input['password'], $user->pass)) {
                $ses =[
                    'id' => $user->id,
                    'name' => $user->name,
                    'logged_time' => time()
                ];
                session()->set('login', $ses);
                echo json_encode(['msg' => 'Logged In', 'code' => 200]);
            } else {
                echo json_encode(['msg' => 'Password not match', 'code' => 400]);
            }
            // print_r($input);
            // exit;
        } else {
            echo json_encode(['msg' => 'Email Not Register', 'code' => 400]);
        }
    }
    public function register()
    {
        $input = $this->request->getVar();
        $file = $this->request->getFile('profile_image');
        if ($file && $file->isValid()) {
            $dire = 'uploads/profile/';
            if (!is_dir($dire)) {
                mkdir($dire, 0777, true);
            }
            $nam = $file->getRandomName();
            $file->move($dire, $nam);
            $input['file_loc'] = $dire . $nam;
            $input['file_name'] = $nam;
        } else {
            unset($input['profile_image']);
            $input['file_loc'] = '';
            $input['file_name'] = '';
        }
        $arr = [
            'pass' => password_hash($input['password'], PASSWORD_DEFAULT),
            'name' => $input['name'],
            'email' => $input['email'],
            'file_name' => $input['file_name'],
            'file_loc' => $input['file_loc']
        ];
        $this->user->insert($arr);
        $main_id = $this->db->insertID();
        if ($main_id) {
            $ses = [
                'id' => $main_id,
                'name' => $input['name'],
                'logged_time' => time()
            ];
            session()->set('login', $ses);
            echo json_encode(['msg' => 'Registered', 'code' => 200]);
            header("Location:" . base_url('dashboard'));
            exit;
        }
    }
    public function logout()
    {
        session()->destroy('login');
		echo json_encode(10);
        // return true
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\User;
use CodeIgniter\API\ResponseTrait;

class AuthController extends BaseController
{
    use ResponseTrait;


    public function register(){
        $model = new User();

        $rule = [
            'name' => 'required|alpha_numeric_space',
            'email' => "required|valid_email|is_unique[users.email]",
            'password' => 'required|min_length[6]'
        ];

        if(!$this->validate($rule)){
            return $this->fail($this->validator->getErrors());
        }

        $name = $this->request->getVar('name');
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ];

        if($model->insert($data)){
            return $this->respondCreated([
                'status' => 201,
                'message' => 'Registrasi Berhasil'
            ]);
        }else{
            return $this->fail('Gagal registrasi', 400);
        }
    }

    public function login(){
    $model = new User();

    $email    = $this->request->getVar('email');
    $password = $this->request->getVar('password');

    $user = $model->where('email', $email)->first();

    if (!$user) {
        return $this->failNotFound('Email tidak ditemukan');
    }

    $verify = password_verify($password, $user['password']);

    if (!$verify) {
        return $this->respond([
            'status'    => 401,
            'message'   => 'Email atau Password salah!'
        ], 401);
    }

    return $this->respond([
        'status'   => 200,
        'message'  => 'Login Berhasil',
        'data'     => [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email']
        ]
    ]);
    }

    public function forgotPassword(){
        $model = new User();
        $email = $this->request->getVar('email');

        $user = $model->where('email', $email)->first();
        if(!$user){
            return $this->failNotFound('Email tidak terdaftar');
        }

        $token = substr(str_shuffle("7f3c2e91chib84alyra4d6akal9c21"), 0,7);
        $db = \Config\Database::connect();
        $db->table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->respond([
            'status' => 200,
            'message' => 'Token reset sudah dibuat',
            'token' => $token
        ]);
    }

    public function resetPassword(){
        $db = \Config\Database::connect();
        $model = new User();

        $token = $this->request->getVar('token');
        $newPassword = $this->request->getVar('password');

        $resetData = $db->table('password_resets')->where('token', $token)->get()->getRow();
        if(!$resetData){
            return $this->fail('Token tidak valid atau sudah kadaluwarsa', 400);
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $model->where('email', $resetData->email)
            ->set(['password' => $hashedPassword])
            ->update();
        
        $db->table('password_resets')->where('email', $resetData->email)->delete();

        return $this->respond([
            'status' => 200,
            'message' => 'Password berhasil diperbarui! Silahkan login kembali'
        ]);
    }
}

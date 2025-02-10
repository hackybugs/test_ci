<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class AdminController extends BaseController
{
    public function index()
    {
        //
    }

    public function dashboard() {
        $userModel = new UserModel();

       return $this->response->setJSON([
            'status' => 'success',
            'message'=> 'welcome to dashboard',
            'total_users' => $userModel->countAllResults(),
            'last_5_users' => $userModel->orderBy('created_at', 'DESC')->limit(5)->findAll()
        ]);
    }

}

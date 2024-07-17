<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use GuzzleHttp\Client;

class UserController extends Controller
{
    public function viewreg(){
        echo view('register');
    }

    public function register()
    {
        helper(['form']);
        $data = [];
        if ($this->request->getMethod() == 'POST') {
            // Validation rules
            $rules = [
                'name' => 'required|min_length[3]|max_length[100]',
                'email' => 'required|min_length[6]|max_length[100]|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]|max_length[255]',
                'profile_picture' => [
                    'uploaded[profile_picture]',
                    'mime_in[profile_picture,image/jpg,image/jpeg,image/png]',
                    'max_size[profile_picture,4096]',
                ],
            ];

            if ($this->validate($rules)) {
                $userModel = new UserModel();
                
                // Get file
                $file = $this->request->getFile('profile_picture');
                $profilePictureName = $file->getRandomName();
                $file->move('uploads', $profilePictureName);

                $userModel->save([
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'profile_picture' => $profilePictureName,
                ]);

                return redirect()->to('/login');
            } else {
                $data['validation'] = $this->validator;
            }
        }
        echo view('register', $data);
    }

    public function login()
    {
        helper(['form']);
        $data = [];
        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'email' => 'required|min_length[6]|max_length[100]|valid_email',
                'password' => 'required|min_length[8]|max_length[255]',
            ];

            if ($this->validate($rules)) {
                $userModel = new UserModel();
                $user = $userModel->where('email', $this->request->getPost('email'))->first();
                
                if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
                    session()->set('user', $user);
                    return redirect()->to('/dashboard');
                } else {
                    $data['error'] = 'Invalid credentials';
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        echo view('login', $data);
    }

    public function dashboard()
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login');
        }
        echo view('dashboard', ['user' => $user]);
    }

    public function profile()
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login');
        }

        helper(['form']);
        $data = ['user' => $user];

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email',
        'profile_picture' => [
            'uploaded[profile_picture]',
            'mime_in[profile_picture,image/jpg,image/jpeg,image/png]',
            'max_size[profile_picture,4096]',
        ]
        ];

            if ($this->request->getPost('password') != '') {
                $rules['password'] = 'required|min_length[8]|max_length[255]';
            }
            if ($this->validate($rules)) {
                $userModel = new UserModel();
                $updateData = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                ];

                if ($this->request->getPost('password') != '') {
                    $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
                }

                if ($this->request->getFile('profile_picture')->isValid()) {
                    $file = $this->request->getFile('profile_picture');
                    $profilePictureName = $file->getRandomName();
                    $file->move('uploads', $profilePictureName);
                    $updateData['profile_picture'] = $profilePictureName;
                }

                $userModel->update($user['id'], $updateData);
                session()->set('user', array_merge($user, $updateData));

                return redirect()->to('/dashboard');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        echo view('profile', $data);
    }

    public function search()
    {
        helper(['form', 'dotenv']);
        $data = [];
        $pixabayApiKey = getenv('YOUR_PIXABAY_API_KEY');

        if ($this->request->getMethod() == 'POST') {
            $query = $this->request->getPost('query');

            $apiKey = $pixabayApiKey;
            $pixabayUrl = 'https://pixabay.com/api/?key=' . $apiKey . '&q=' . urlencode($query);

            try {
                $client = new Client();
                $response = $client->request('GET', $pixabayUrl);

                if ($response->getStatusCode() == 200) {
                    $results = json_decode($response->getBody(), true)['hits'];
                    $data['results'] = $results;
                } else {
                    // Handle HTTP error responses
                    $data['error'] = 'Pixabay API request failed: ' . $response->getStatusCode();
                }
            } catch (\Exception $e) {
                // Handle Guzzle exceptions
                $data['error'] = 'Pixabay API request failed: ' . $e->getMessage();
            }
        }
        echo view('search', $data);
    }
}

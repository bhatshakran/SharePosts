<?php
  class Users extends Controller {
    public function __construct(){
        $this->userModel = $this->model('User');

    }

    public function register(){
      // Check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process form
        
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data =[
            'name' => trim($_POST['name']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'name_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => ''
          ];

        //   Validate Email
        if(empty($data['email'])){
            $data['email_err'] = 'Please enter email';
        }else {
            // Check email server side
            if($this->userModel->findUserByEmail($data['email'])){
                $data['email_err'] = 'Email is already taken';
            }
        }

        // Validate Name
        if(empty($data['name'])){
            $data['name_err'] = 'Please enter name';
        }

        // Validate Password
        if(empty($data['password'])){
            $data['password_err'] = 'Please enter Password';
        }elseif(strlen($data['password']) < 6) {
            $data['password_err'] = 'Password must be atleast 6 characters long';
        }


        // Validate Confirm Password
        if(empty($data['confirm_password'])){
            $data['confirm_password_err'] = 'Please confirm password';
        } elseif($data['password'] != $data['confirm_password']){
            $data['confirm_password_err'] = 'Passwords do not match!';
        }

        // Make sure all the error fields are empty
        if(empty($data['name_err']) && empty($data['email_err'])
         && empty($data['password_err']) && empty($data['confirm_password_err'])){
            // Validated 
            die('Success');
        }else{
            // Load view with errors
            $this->view('users/register', $data);
        }

      } else {
        // Init data
        $data =[
          'name' => '',
          'email' => '',
          'password' => '',
          'confirm_password' => '',
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];

        // Load view
        $this->view('users/register', $data);
      }
    }

    public function login(){
      // Check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process form

        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data =[  
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'email_err' => '',
            'password_err' => '',
          ];

           //   Validate Email
        if(empty($data['email'])){
            $data['email_err'] = 'Please enter email';
        }

        // Validate Password
        if(empty($data['password'])){
            $data['password_err'] = 'Please enter Password';
        }

         // Make sure all the error fields are empty
         if(empty($data['email_err']) && empty($data['password_err'])){
            // Validated 
            die('Success');
        }else{
            // Load view with errors
            $this->view('users/login', $data);
        }

      } else {
        // Init data
        $data =[    
          'email' => '',
          'password' => '',
          'email_err' => '',
          'password_err' => '',        
        ];

        // Load view
        $this->view('users/login', $data);
      }
    }
  }
<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;
use stdClass;

require './vendor/autoload.php';

class FirebaseService {

    private $firebase;
    private $db;
    private $auth;

    public function __construct()
    {
        $this->firebase = (new Factory)->withServiceAccount('./key/crudusers-5b92c-f11c1e50e899.json')
                                        ->withDatabaseUri('https://crudusers-5b92c-default-rtdb.firebaseio.com');
        $this->db = $this->firebase->createDatabase(); 
        $this->auth =  $this->firebase->createAuth(); 
        
    }
    
    /* ****************************
     * DATABASE       
    *******************************/

    //Obtiene los datos de la base (no los de la cuenta)
    public function getAllUsers(){
        $reference  = $this->db->getReference('/usuarios');
        $registros = $reference->getValue();
        \Log::info($registros);
        return $registros;
    }

    public function getUserByDoc($doc){
        $user = $this->db->getReference('/usuarios')->orderByChild('documento')->equalTo($doc)->getValue();
        return $user;
    }

    public function updateUser($data){
        $id = $data['id'];
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $email = $data['email'];

        $updates = [
            'usuarios/'.$id.'/nombre'=>$nombre,
            'usuarios/'.$id.'/apellido'=>$apellido,
            'usuarios/'.$id.'/email'=>$email,
        ];
        try{
            $this->db->getReference()->update($updates);
            return 'Successfully updated';
        }catch(\Exception $e){
            return $e->getMessage();
        }

    }

    public function createUser($data){
        $doc = $data['documento'];
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $email = $data['email'];
        $pais = $data['pais'];
        try{

            $this->db->getReference('usuarios')
            ->push([
                    'documento'=>$doc,
                    'nombre'=>$nombre,
                    'apellido'=>$apellido,
                    'email'=>$email,
                    'pais'=>$pais
                ]);
            return "User successfully created.";
        }catch(\Exception $e){
            
            return $e->getMessage();
        }
                
    }

    /**
     * @params $user_data [email,password,name]
     * 
     */
    public function createAccount($user_data){
        $user = [
            'email' => $user_data['email'],
            'emailVerified' => false,
            'password' => $user_data['password'],
            'displayName' => $user_data['name']
        ];

        return $this->auth->createUser($user);
    }

    
    public function signIn($user_data){
        $response = new stdClass();
        $response->message = null;
        $response->code = null;

        $email = $user_data['email'];
        $pass= $user_data['password'];

       try{

           $result = $this->auth->signInWithEmailAndPassword($email,$pass);
           $response->message = "Usuario verificado con exito";
           $response->code = 200;

        }catch(\Exception $e){
            $response->message = $e->getMessage();
            $response->code = 400;
            return $response;
        }
        return $response;
    }
}
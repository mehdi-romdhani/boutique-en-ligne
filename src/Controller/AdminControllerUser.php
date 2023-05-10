<?php

namespace App\Controller;

use App\Model\AdminModel;

class AdminControllerUser{

    private $model;

    public function __construct()
    {
        $this->model = new AdminModel();
    }

    public function GetAllRoles() {

        $roles = $this->model->GetAllRoles();                   // renvoie un tableau PHP avec les id et noms de tous les roles

        $json = json_encode($roles, JSON_PRETTY_PRINT);         // encode le tableau en format JSON
        echo $json;
    }

    public function GetUsersDataByRole($idRole) {

        $dataUsers = $this->model->GetUserDataByRoleId($idRole);        // renvoie un tableau php de toutes les data des users appartenant au role choisi

        return $dataUsers;

    }

    public function GetAllRoleExeptActual($idActualRole) {

        $roles = $this->model->GetAllRoleExeptActualById($idActualRole);
        
        return $roles;

    }

    public function ChangeUserRole($idRole, $idUser) {

        $change = $this->model->UpdateRole($idRole, $idUser);

        return $change;

    }

    public function DeleteUser($idUser) {

        $delete = $this->model->DeleteUser($idUser);

        return $delete;

    }

}

?>
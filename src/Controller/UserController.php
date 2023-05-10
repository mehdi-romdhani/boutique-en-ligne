<?php

namespace App\Controller;
use App\Model\UserModel;


class UserController
{

    private $model;

    public function __construct()
    {
        $this->model = new UserModel;

    }

    public function Register(?string $login, ?string $email, ?string $password, ?string $passwordConfirm)
    {

        $login = htmlspecialchars(trim($login));
        $email = htmlspecialchars(trim($email));
        $password = htmlspecialchars(trim($password));
        $passwordConfirm = htmlspecialchars(trim($passwordConfirm));

        $messages = [];

        $row = $this->model->RowCount('user', 'login', $login);

        if ($row <= 0 && strlen($login) >= 4 && !preg_match("[\W]", $login) && preg_match("/@/", $email) && preg_match("/\./", $email) && strlen($password) >= 5 && $password == $passwordConfirm) {

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $this->model->InsertUserDb($login, $email, $hash) == 'okSignup' ? $messages['okReg'] = 'Your account is now created and you can login' : $messages['errorRegDb'] = 'There was an error with the database insertion, please try again later';

        } else {

            if ($row > 0) {

                $messages['errorLoginExist'] = 'The login already exist. Please choose another one';
            }
            if (strlen($login) <= 3 || preg_match("[\W]", $login)) {

                $messages['errorLogin'] = 'Your login must contain at least 4 caracters and no specials caracters';
            }
            if (!preg_match("/@/", $email) || !preg_match("/\./", $email)) {

                $messages['errorEmail'] = 'Your email must contain a \'@\' and a \'.\'';
            }
            if (strlen($password) <= 4) {

                $messages['errorPassLong'] = 'Your password must contain at least 5 caracters';
            }
            if ($password != $passwordConfirm) {

                $messages['errorPassMatch'] = 'The passwords do not match';
            }
        }

        $json = json_encode($messages, JSON_PRETTY_PRINT);
        echo $json;
    }

    public function Connect(?string $login, ?string $password)
    {

        $login = htmlspecialchars(trim($login));
        $password = htmlspecialchars(trim($password));

        $messages = [];

        $row = $this->model->RowCount('user', 'login', $login);

        if ($row == 1) {


            $userDataDb = $this->model->GetUserData($login);
            //var_dump($userDataDb);

            if(password_verify($password, $userDataDb['password'])) {

                $_SESSION['user'] = $userDataDb;

                $messages['okConn'] = 'You\'re connected';

            } else {
                $messages['errorPass'] = 'Wrong password';
            }

        } else {
            $messages['errorLogin'] = 'The login do not exist. If you don\'t have an account, please signup.';
        }

        $json = json_encode($messages, JSON_PRETTY_PRINT);
        echo $json;
    }

    public function Update(?string $login, ?string $passwordNew, ?string $passwordNewConfirm, ?string $password, ?string $email, ?string $firstname, ?string $lastname, ?string $birthdate, ?string $phoneNumber)
    {

        $login = htmlspecialchars(trim($login));
        $passwordNew = htmlspecialchars(trim($passwordNew));
        $passwordNewConfirm = htmlspecialchars(trim($passwordNewConfirm));
        $password = htmlspecialchars(trim($password));
        $email = htmlspecialchars(trim($email));
        $firstname = htmlspecialchars(trim($firstname));
        $lastname = htmlspecialchars(trim($lastname));
        $birthdate = htmlspecialchars(trim($birthdate));
        $phoneNumber = htmlspecialchars(trim($phoneNumber));

        $messages = [];

        $sessionId = $_SESSION['user']['id'];
        $passwordTrue = $_SESSION['user']['password'];

        if (password_verify($password, $passwordTrue)) {

            if (!empty($login) && $_SESSION['user']['login'] != $login && strlen($login) >= 4 && !preg_match("[\W]", $login)) {

                $row = $this->model->RowCount('user', 'login', $login);

                if ($row === 0) {

                    $this->model->UpdateOneById($sessionId, 'login', $login, 'user', 'okLog') == 'okLog' ? $messages['okLoginEdit'] = 'Your login has been edited' : $messages['errorLoginDb'] = 'There was an error with the database insertion, please try again later';

                    $_SESSION['user']['login'] = $login;

                } else {
                    $messages['errorLoginExist'] = 'The login already exist';
                }

            } elseif (strlen($login) < 4 || preg_match("[\W]", $login)) {

                $messages['errorLogin'] = "Your login must contain at least 4 caracters and no specials caracters";
            }

            if (!empty($passwordNew) && !empty($passwordNewConfirm) && $passwordNew == $passwordNewConfirm && strlen($passwordNew) >= 5) {

                $hash = password_hash($passwordNew, PASSWORD_DEFAULT);

                $this->model->UpdateOneById($sessionId, 'password', $hash, 'user', 'okPass') == 'okPass' ? $messages['okPassEdit'] = 'Your password has been edited' : $messages['errorPassDb'] = 'There was an error with the database insertion, please try again later';;

            } elseif (strlen($passwordNew) < 5 && !empty($passwordNew)) {

                $messages['errorPassLong'] = 'Your password must contain at least 5 caracters';

            } elseif (!empty($passwordNew) && empty($passwordNewConfirm)) {

                $messages['errorPassConfirm'] = 'Please confirm password';

            } elseif ($passwordNew != $passwordNewConfirm) {

                $messages['errorPassDiff'] = 'The passwords are differents';
            }

            if (!empty($email) && $_SESSION['user']['email'] != $email && preg_match("/@/", $email) && preg_match("/\./", $email)) {

                $row = $this->model->RowCount('user', 'email', $email);

                if ($row === 0) {

                    $this->model->UpdateOneById($sessionId, 'email', $email, 'user', 'okEmail') == 'okEmail' ? $messages['okEmailEdit'] = 'Your email has been edited' : $messages['errorEmailDb'] = 'There was an error with the database insertion, please try again later';

                    $_SESSION['user']['email'] = $email;

                } else {
                    $messages['errorEmailExist'] = 'The email is already liked to another account';
                }

            } elseif (!preg_match("/@/", $email) || !preg_match("/\./", $email)) {

                $messages['errorEmail'] = 'Your email must contain a \'@\' and a \'.\'';
            }

            if (!empty($firstname) && $_SESSION['user']['firstname'] != $firstname) {

                $this->model->UpdateOneById($sessionId, 'firstname', $firstname, 'user', 'okFirstname') == 'okFirstname' ? $messages['okFirstnameEdit'] = 'Your firstname has been edited' : $messages['errorFirstnameDb'] = 'There was an error with the database insertion, please try again later';

                $_SESSION['user']['firstname'] = $firstname;

            }

            if (!empty($lastname) && $_SESSION['user']['lastname'] != $lastname) {

                $this->model->UpdateOneById($sessionId, 'lastname', $lastname, 'user', 'okFirstname') == 'okLastname' ? $messages['okLastnameEdit'] = 'Your lastname has been edited' : $messages['errorLastnameDb'] = 'There was an error with the database insertion, please try again later';

                $_SESSION['user']['lastname'] = $lastname;

            }

            if (!empty($birthdate) && $_SESSION['user']['birthdate'] != $birthdate) {

                $this->model->UpdateOneById($sessionId, 'birth_date', $birthdate, 'user', 'okBirthdate') == 'okBirthdate' ? $messages['okBirthdateEdit'] = 'Your birth date has been edited' : $messages['errorBirthdateDb'] = 'There was an error with the database insertion, please try again later';

                $_SESSION['user']['birthdate'] = $birthdate;

            }

            if (!empty($phoneNumber) && $_SESSION['user']['phoneNumber'] != $phoneNumber) {

                $row = $this->model->RowCount('user', 'phone_number', $phoneNumber);

                if ($row === 0) {

                    $this->model->UpdateOneById($sessionId, 'phone_number', $phoneNumber, 'user', 'okPhoneNumber') == 'okPhoneNumber' ? $messages['okPhoneNumberEdit'] = 'Your phone number has been edited' : $messages['errorPhoneNumberDb'] = 'There was an error with the database insertion, please try again later';

                    $_SESSION['user']['phoneNumber'] = $phoneNumber;

                } else {
                    $messages['errorPhoneNumberExist'] = 'The phone number is already liked to another account';
                }
            }

        } else {

            $messages['errorPassWrong'] = 'Wrong password';
        }

        $json = json_encode($messages, JSON_PRETTY_PRINT);
        echo $json;
    }

    public static function Disconnect()
    {

        session_destroy();
        header('Location: disconnect.php');

    }

    public function Delete()
    {

        $messages = [];

        if ($_SESSION) {

            $sessionId = $_SESSION['user']['id'];

            $this->model->DeleteLine('user', $sessionId) == 'okDel' ? ((session_destroy()) . ($messages['okDelAccount'] = 'Your account has been deleted')) : $messages['errorDelDb'] = 'There was an error with the database deletion, please try again later';

        } else {
            $messages['errorDel'] = 'You have to be connected to delete your account';
        }

        $json = json_encode($messages, JSON_PRETTY_PRINT);
        echo $json;
    }
}

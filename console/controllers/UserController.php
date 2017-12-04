<?php
namespace console\controllers;

use common\models\User;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class UserController for manual user management
 *
 * @package console\controllers
 */
class UserController extends Controller
{
    /**
     * Add new user in format <username> <password> <email>
     * @param $username
     * @param $password
     * @param $email
     */
    public function actionAdd($username, $password, $email)
    {
        $status = $this->ansiFormat('Error!', Console::FG_RED);
        $user = User::findByUsername($username);
        if ($user) {
            $username = $this->ansiFormat($username, Console::FG_RED);
            $this->stderr("    > {$status} User with name {$username} already exist!" . PHP_EOL);
            exit(Controller::EXIT_CODE_ERROR);
        } else {
            $user = new User(['username' => $username, 'email' => $email]);
            $user->setPassword($password);
            if ($user->save()) {
                $status = $this->ansiFormat('Success!', Console::FG_GREEN);
                $username = $this->ansiFormat($username, Console::FG_GREEN);
                $password = $this->ansiFormat($password, Console::FG_GREEN);
                $this->stdout("    > {$status} User with name {$username} and password {$password} created!" . PHP_EOL);
                exit(Controller::EXIT_CODE_NORMAL);
            } elseif ($user->hasErrors()) {
                $messages = $user->getFirstErrors();
                $this->stderr("    > {$status} User with name {$username} not created!" . PHP_EOL);
                foreach ($messages as $message) {
                    $this->stderr("      - {$message}." . PHP_EOL);
                }
                exit(Controller::EXIT_CODE_ERROR);
            } else {
                $this->stderr("    > {$status} Undefined error occurred!" . PHP_EOL);
                exit(Controller::EXIT_CODE_ERROR);
            }
        }
    }
}

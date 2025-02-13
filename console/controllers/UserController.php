<?php

namespace console\controllers;

use common\models\User;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * UserController used to create a User model.
 */
class UserController extends Controller
{
    /**
     * Creates a new User model.
     *
     * @return int
     */
    public function actionCreate()
    {
        $user = new User();
        $user->status = User::STATUS_ACTIVE;
        $user->username = Console::input('Enter the username: ');
        $user->password = Console::input('Enter the password: ');
        $user->generateAuthKey();

        if ($user->save()) {
            Console::stdout("User created (auth_key={$user->auth_key})\n");
            return ExitCode::OK;
        } else {
            Console::stderr("Failed to create a user\n");
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }
}

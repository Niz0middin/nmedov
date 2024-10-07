<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SeedController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */

    public function actionUser($username = 'nmadmin', $password = 'P@ssword_01')
    {
        // Create the admin user if it doesn't exist
        $user = User::find()->where(['username' => $username])->one();
        if (!$user) {
            $user = new User();
            $user->username = $username;
            $user->email = 'nmadmin@mail.com';
            $user->status = User::STATUS_ACTIVE;
            $user->setPassword($password);
            $user->generateAuthKey();
            if ($user->save()) {
                echo "Admin user created: $username\n";
            } else {
                echo "Failed to create admin user: " . implode(', ', $user->getErrors()) . "\n";
            }
        } else {
            echo "Admin user already exists: $username\n";
        }

        // Create the superadmin role if it doesn't exist
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('superadmin');
        if (!$role) {
            $role = $auth->createRole('superadmin');
            $auth->add($role);
            echo "Superadmin role created\n";
        } else {
            echo "Superadmin role already exists\n";
        }

        $permission = $auth->getPermission('/*');
        if (!$permission) {
            $permission = $auth->createPermission('/*');
            $auth->add($permission);
            echo "Wildcard permission /* created\n";
        } else {
            echo "Wildcard permission /* already exists\n";
        }

        // Assign the /* permission to the superadmin role
        if (!$auth->hasChild($role, $permission)) {
            $auth->addChild($role, $permission);
            echo "Wildcard permission /* assigned to superadmin role\n";
        } else {
            echo "Superadmin role already has wildcard permission /*\n";
        }

        // Assign the superadmin role to the user
        if (!$auth->getAssignment('superadmin', $user->id)) {
            $auth->assign($role, $user->id);
            echo "Superadmin role assigned to user: $username\n";
        } else {
            echo "User already has superadmin role: $username\n";
        }
        return ExitCode::OK;
    }
}

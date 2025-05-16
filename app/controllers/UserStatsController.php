<?php

require_once __DIR__ . '/../models/LoginHistory.php';
require_once __DIR__ . '/../models/User.php';

class UserStatsController
{
    public static function getLoginStats($userId)
    {
        return LoginHistory::getLoginCountByUser($userId);
    }

    public static function getLastLoginDate($userId)
    {
        return LoginHistory::getLastLoginByUser($userId);
    }

    public static function getUserInfo($userId)
    {
        return User::findById($userId);
    }
}

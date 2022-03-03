<?php
/**
 * Created by PhpStorm.
 * User: dd
 * Date: 03/03/22
 * Time: 01:31
 */

namespace App\Entity;


class UserException extends \InvalidArgumentException
{
    public static $errorLength = "Password must be minimum 8 characters long";
    public static $errorDigit = "Password must contain at least one digit";
    public static $errorLower = "Password must contain at least one lowercase character";
    public static $errorUpper = "TPassword must contain at least one uppercase character";
}
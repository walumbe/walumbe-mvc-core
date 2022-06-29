<?php

namespace app\core\db;

//object Relational Mapping

use app\core\Application;
use app\core\Model;

abstract class DBModel extends Model
{
    abstract public function tableName():string;

    abstract public function attributes(): array;

    abstract public function primaryKey(): string;

    public function save()
    {
        $tableName  = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName(".implode(',', $attributes).")
        VALUES(".implode(',', $params).")");
        foreach ($attributes as $attribute)
        {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

//        echo "<pre>";
//        var_dump($statement, $params, $attributes);
//        echo "</pre>";
//        Application::$app->database->pdo->exec($statement);
        $statement->execute();
        return true;
    }

    public function findOne($where) // email => nathanwalumbe@gmail.com, firstname => Jonatan
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item)
        {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function prepare($sql)
    {
       return Application::$app->database->pdo->prepare($sql);
    }
}
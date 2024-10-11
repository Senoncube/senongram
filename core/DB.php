<?php

namespace core;

class DB
{
    protected \PDO $pdo;

    public function __construct(string $hostname, string $login, string $password, string $db) {
        $this->pdo = new \PDO("mysql: host=$hostname;dbname=$db", $login, $password);
    }

    private function double_implode(array $arr, string $sep): string
    {
        $parts = [];
        foreach ($arr as $key => $value)
            $parts[] = "$key = :$key";
        return implode($sep, $parts);
    }

    public function select(string $table, array $fields = ['*'], array $conditions = null,
                           bool $or = false, int $page_i = 0, int $page_offset = 1000000, string $desc = ''): array
    {
        $fieldsStr = implode(', ', $fields);
        $whereStr = '';
        if ($conditions)
            $whereStr = "where " . $this->double_implode($conditions, $or? ' or ' : ' and ');
        $order = '';
        if ($desc)
            $order = " order by $desc desc ";
        $page_i = $page_i * $page_offset;
        $res = $this->pdo->prepare("select $fieldsStr from $table $whereStr $order limit $page_i, $page_offset");

        $res->execute($conditions);
        return $res->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function update(string $table, array $fields, string $id_field, string|int $id): bool
    {
        $fieldsStr = $this->double_implode($fields, ', ');
        $res = $this->pdo->prepare("UPDATE $table SET $fieldsStr WHERE $id_field = :id");
        return $res->execute(array_merge($fields, ['id' => $id]));
    }

    public function insert(string $table, array $fields): bool
    {
        $fieldsStr = implode(', ', array_keys($fields));
        $params = [];
        foreach ($fields as $key => $value) {
            $params[] = ':' . $key;
        }
        $paramsStr = implode(', ', $params);
        $res = $this->pdo->prepare("INSERT INTO $table($fieldsStr) VALUES ($paramsStr)");
        return $res->execute($fields);
    }

    public function delete(string $table, string $id_field, string|int $id): bool
    {
        $res = $this->pdo->prepare("DELETE FROM $table WHERE $id_field = :id");
        $res->bindValue('id', $id);
        return $res->execute();
    }

    public function call(string $procedureName, $params): array
    {
        $parts = [];
        $newParams = [];
        for ($i = 0; $i < count($params); $i++) {
            $parts[] = ":p$i";
            $newParams[":p$i"] = $params[$i];
        }
        $parts = implode(', ', $parts);
        $res = $this->pdo->prepare("CALL $procedureName ($parts)");
        $res->execute($newParams);
        return $res->fetchAll(\PDO::FETCH_ASSOC);
    }
}
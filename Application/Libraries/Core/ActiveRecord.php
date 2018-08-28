<?php

namespace Libraries\Core;

use Libraries\Utilities\ClassUtils;
use Libraries\Utilities\InflectUtils;
use Libraries\Utilities\StringUtils;

abstract class ActiveRecord implements ActiveRecordInterface
{

    /**
     * Return database table name associated with the model
     * @return string
     */
    public static function getTableName(): string
    {
        try {
            $modelName = ClassUtils::getShortName(get_called_class());
        } catch (\ReflectionException $ex) {
            return '';
        }

        $modelNameParts = StringUtils::splitByCapitalLetter($modelName);
        $last = count($modelNameParts) - 1;

        /**
         * Convert last word to plural
         */
        $modelNameParts[$last] = InflectUtils::pluralize($modelNameParts[$last]);

        return strtolower(implode('_', $modelNameParts));
    }

    /**
     * Return array with object (model) properties
     * @param string $types
     * @param bool $skipNull
     * @return array
     */
    protected function getObjectProperties(string $types = 'private', bool $skipNull = true): array
    {
        try {
            $properties = ClassUtils::getProperties($this, $types);
        } catch (\ReflectionException $ex) {
            return [];
        }

        $result = [];

        foreach ($properties as $propertyName => $reflectionProperty) {
            /**
             * Set private and protected members accessible for getValue/setValue
             * @var \ReflectionProperty $reflectionProperty
             */
            $reflectionProperty->setAccessible(true);
            $propertyValue = $reflectionProperty->getValue($this);

            if (is_null($propertyValue) && $skipNull) {
                continue;
            }

            $propertyName = StringUtils::convertToUnderscored($propertyName);
            $result[$propertyName] = $propertyValue;

        }

        return $result;
    }

    /**
     * Create an object from single record of table
     * @param array $row
     * @return ActiveRecord
     */
    protected static function instantiation(array $row): ActiveRecord
    {
        $calledClass = get_called_class();
        $calledObject = new $calledClass;

        ClassUtils::callSetters($calledObject, $row);

        return $calledObject;
    }

    /**
     * Return objects array that has been created by query
     * @param string $query
     * @param array $params
     * @return array
     */
    public static function findByQuery(string $query, array $params = []): array
    {
        $db = new Database(DatabaseFactory::getFactory()->getConnection());
        $db->prepare($query);

        foreach ($params as $param => $value) {
            $db->bind($param, $value);
        }

        $db->execute();
        $objects = [];

        while ($row = $db->fetchSingle()) {
            $objects[] = self::instantiation($row);
        }

        return $objects;
    }

    /**
     * Gets table row with selected id and return it as object
     * @param int $id
     * @return ActiveRecord|null
     */
    public static function findById(int $id): ?ActiveRecord
    {
        $query = "SELECT * FROM " . self::getTableName() . " WHERE id = :id LIMIT 1";
        $objects = self::findByQuery($query, [":id" => $id]);

        return !empty($objects) ? $objects[0] : null;
    }

    /**
     * Returns all table rows as objects array
     * @return array
     */
    public static function findAll(): array
    {
        return self::findByQuery("SELECT * FROM " . self::getTableName());
    }

    /**
     * Return table number of rows
     * @return int
     */
    public static function getRowsCount(): int
    {
        $db = new Database(DatabaseFactory::getFactory()->getConnection());

        $query = "SELECT COUNT(*) AS row_count FROM " . self::getTableName();
        $db->query($query);

        if ($result = $db->fetchSingle()) {
            return $result['row_count'];
        }

        return 0;
    }

    /**
     * Create a new record
     * @return bool
     */
    public function create(): bool
    {
        $db = new Database(DatabaseFactory::getFactory()->getConnection());
        $properties = $this->getObjectProperties();

        $query = "INSERT INTO " . self::getTableName() . "(" . implode(',', array_keys($properties)) . ") ";
        $query .= "VALUES (:" . implode(",:", array_keys($properties)) . ")";
        $db->prepare($query);

        foreach ($properties as $property => $value) {
            $db->bind(':' . $property, $value);
        }

        if (!$db->execute()) {
            return false;
        }

        $this->setId($db->lastId());
        return ($db->affectedRows() === 1);
    }

    /**
     * Update existing record
     * @return bool
     */
    public function update(): bool
    {
        $db = new Database(DatabaseFactory::getFactory()->getConnection());
        $properties = $this->getObjectProperties();
        $pairs = [];

        foreach ($properties as $property => $value) {
            $pairs[] = $property . '=:' . $property;
        }

        $query = "UPDATE " . self::getTableName() . " SET ";
        $query .= implode(',', $pairs) . " WHERE id=:id";
        $db->prepare($query);

        foreach ($properties as $property => $value) {
            $db->bind(':' . $property, $value);
        }

        if (!$db->execute()) {
            return false;
        }

        return ($db->affectedRows() === 1);
    }

    /**
     * Delete record with id specified in object id property
     * @return bool
     */
    public function delete(): bool
    {
        $db = new Database(DatabaseFactory::getFactory()->getConnection());
        $db->prepare("DELETE FROM " . self::getTableName() . " WHERE id = :id");
        $db->bind(":id", $this->getId());

        if ($db->execute()) {
            return ($db->affectedRows() === 1) ? true : false;
        }

        return false;
    }

    /**
     * Create new record or update existing if object id has been set
     * @return bool
     */
    public function save(): bool
    {
        $id = $this->getId();
        return is_null($id) ? $this->create() : $this->update();
    }

}
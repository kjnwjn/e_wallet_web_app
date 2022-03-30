<?php
class Account extends DB
{
    function INSERT($field = [])
    {
        $key_field = [];
        $value_field = [];

        foreach ($field as $key => $value) {
            array_push($key_field, $key);
            array_push($value_field, '"' . $value . '"');
        }

        $value = implode(',', $value_field);
        $field_name = implode(',', $key_field);

        try {
            $sql = 'INSERT INTO account (' . $field_name . ') VALUES (' . $value . ')';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function SELECT_ONE($condition = '', $conditionValue = '')
    {
        
        $sql = 'SELECT * from account WHERE ' . $condition . ' = "' . $conditionValue . '"';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_array($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }
    
    function SELECT($condition = '', $conditionValue = '')
    {
        $sql = 'SELECT * from `account` WHERE ' . $condition . ' = "' . $conditionValue . '"';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }

    function SELECT_ORDER_BY_ASC($condition = '', $conditionValue = '',$fieldValue = '')
    {
        $sql = 'SELECT * from `account` WHERE '. $condition . ' = "' . $conditionValue . '" ORDER BY `'.$fieldValue . '` ASC';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }
    function SELECT_ORDER_BY_DESC($condition = '', $conditionValue = '',$fieldValue = '')
    {
        $sql = 'SELECT * from `account` WHERE '. $condition . ' = "' . $conditionValue . '" ORDER BY `'.$fieldValue . '` DESC';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }

    function SELECT_ALL()
    {
        $sql = 'SELECT * from account';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }

    function UPDATE_ONE($conditions = [], $toUpdate = [])
    {
        try {
            $conditionName = array_keys($conditions)[0];
            $conditionValue = $conditions[$conditionName];
            $toUpdateName = array_keys($toUpdate)[0];
            $newValue = $toUpdate[$toUpdateName];
            $sql = 'UPDATE account SET ' . $toUpdateName . ' = "' . $newValue . '" WHERE ' . $conditionName . ' = "' . $conditionValue . '"';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $sql = 'UPDATE account SET updatedAt = ' . time() . ' WHERE ' . $conditionName . ' = "' . $conditionValue . '"';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

<?php
class Transaction extends DB
{
    function SELECT_ONE($condition = '', $conditionValue = '')
    {
        $sql = 'SELECT * from `transaction` WHERE ' . $condition . ' = "' . $conditionValue . '"';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_array($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }

    function SELECT($condition = '', $conditionValue = '')
    {
        $sql = 'SELECT * from `transaction` WHERE ' . $condition . ' = "' . $conditionValue . '"';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }
   
    function SELECT_INNER_JOIN($column = [],$table = '',$condition ='')
    {
        $value_field = [];

        foreach ($column as $key => $value) {
            array_push($value_field, $value );

        }
        
        $value = implode(',', $value_field);
        $sql = 'SELECT '. $value.' from transaction INNER JOIN '. $table .' ON ' .$condition . '';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_array($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }

    function SELECT_ALL()
    {
        $sql = 'SELECT * from `transaction`';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }
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
            $sql = 'INSERT INTO transaction (' . $field_name . ') VALUES (' . $value . ')';
            $stmt = $this->conn->prepare($sql);
            if(!$stmt){
                echo "Prepare failed: (". $this->conn->error.") ".$this->conn->error."<br>";
             }
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    

    function UPDATE_ONE($conditions = [], $toUpdate = [])
    {
        try {
            $conditionName = array_keys($conditions)[0];
            $conditionValue = $conditions[$conditionName];
            $toUpdateName = array_keys($toUpdate)[0];
            $newValue = $toUpdate[$toUpdateName];
            $sql = 'UPDATE transaction SET ' . $toUpdateName . ' = "' . $newValue . '" WHERE ' . $conditionName . ' = "' . $conditionValue . '"';
            $stmt = $this->conn->prepare($sql);
            if(!$stmt){
                echo "Prepare failed: (". $this->conn->error.") ".$this->conn->error."<br>";
             }
            $stmt->execute();
            $sql = 'UPDATE transaction SET updatedAt = ' . time() . ' WHERE ' . $conditionName . ' = "' . $conditionValue . '"';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
}

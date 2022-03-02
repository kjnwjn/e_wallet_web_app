<?php
class Account extends DB
{
    public function is_email_exit($email)
    {
        $sql = "SELECT * FROM account WHERE email = ?";
        $rows = $this->conn->prepare($sql);
        $rows->bind_param('s', $email);
        $rows->execute();
        $result = $rows->fetch();
        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function is_phone_number_exit($phoneNumber)
    {
        $sql = "SELECT * FROM account WHERE phoneNumber = ?";
        $rows = $this->conn->prepare($sql);
        $rows->bind_param('s', $phoneNumber);
        $rows->execute();
        $result = $rows->fetch();
        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function login($phoneNumber, $password)
    {
        $sql = "SELECT * FROM account WHERE phoneNumber = " . $phoneNumber . "";
        $rows = $this->conn->query($sql);
        $result = mysqli_fetch_array($rows, MYSQLI_ASSOC);
        // echo $password;
        if (strlen($result['password']) <= 6) {
            if ($password === $result['password']) {
                $_SESSION['authenticated'] = true;
                return true;
            }
        } else if (password_verify($password, $result['password'])) {
            $_SESSION['authenticated'] = true;
            return true;
        } else {
            return false;
        }
    }

    public function checkActive($phoneNumber)
    {
        $sql = "SELECT * FROM account WHERE phoneNumber = " . $phoneNumber . "";
        $rows = $this->conn->query($sql);

        $result = mysqli_fetch_array($rows, MYSQLI_ASSOC);
        if (!$result['active']) {
            return false;
        } else {
            return true;
        }
    }

    public function updateActive($active, $phoneNumber)
    {
        $sql = "UPDATE account SET active = ? WHERE phoneNumber = ?";
        $rows = $this->conn->prepare($sql);
        $rows->bind_param('ss', $active, $phoneNumber);
        try {
            if ($rows->execute()) {
                return array(
                    "status" => true,
                    "msg" => "",
                );
            } else {
                return array(
                    "status" => false,
                    "msg" => "",
                );
            };
        } catch (Exception $e) {
            return array(
                "status" => false,
                "msg" => "",
            );
        }
    }

    public function updatePassword($newPassword, $phoneNumber)
    {
        $sql = "UPDATE account SET password = ? WHERE phoneNumber = ?";
        $rows = $this->conn->prepare($sql);
        $rows->bind_param('ss', $newPassword, $phoneNumber);
        try {
            if ($rows->execute()) {
                return true;
            } else {
                return false;
            };
        } catch (Exception $e) {
            return false;
        }
    }

    public function checkWrongPassword($phoneNumber)
    {
        $sql = "SELECT * FROM account WHERE phoneNumber = " . $phoneNumber . "";
        $rows = $this->conn->query($sql);
        $result = mysqli_fetch_array($rows, MYSQLI_ASSOC);
        if ($result['wrongPassword'] > 0) {
            return $result['wrongPassword'];
        } else {
            return false;
        }
    }

    public function updateWrongPassword($wrongpassword, $phoneNumber)
    {
        $sql = "UPDATE account SET wrongpassword = ? WHERE phoneNumber = ?";
        $rows = $this->conn->prepare($sql);
        $rows->bind_param('ss', $wrongpassword, $phoneNumber);
        try {
            if ($rows->execute()) {
                return true;
            } else {
                return false;
            };
        } catch (Exception $e) {
            return false;
        }
    }

    public function checkAbnormal($phoneNumber)
    {
        $sql = "SELECT * FROM account WHERE phoneNumber = " . $phoneNumber . "";
        $rows = $this->conn->query($sql);
        $result = mysqli_fetch_array($rows, MYSQLI_ASSOC);
        if ($result['abnormal'] > 0) {
            return $result['abnormal'];
        } else {
            return false;
        }
    }

    public function updateAbnormal($abnormal, $phoneNumber)
    {
        $sql = "UPDATE account SET abnormal = ? WHERE phoneNumber = ?";
        $rows = $this->conn->prepare($sql);
        $rows->bind_param('ss', $abnormal, $phoneNumber);
        try {
            if ($rows->execute()) {
                return true;
            } else {
                return false;
            };
        } catch (Exception $e) {
            return false;
        }
    }

    public function add_Account($email, $phoneNumber, $password, $fullName, $address, $date, $idCard1, $idCard2)
    {
        $sql = "INSERT INTO account( email, phoneNumber, password, fullName, address, date, idCard1, idCard2) VALUES (?,?,?,?,?,?,?,?)";
        $rows = $this->conn->prepare($sql);
        $rows->bind_param('ssssssss', $email, $phoneNumber, $password, $fullName, $address, $date, $idCard1, $idCard2);
        // $rows->execute();
        try {
            if ($rows->execute()) {
                return true;
            } else {
                return false;
            };
        } catch (Exception $e) {
            return false;
        };
    }

    public function getAccountByActiveStatus($status = 0)
    {
        // $status = 1 ==> get active account
        // $status = 0 ==> get pending account
        $conn = $this->conn;
        $sql = "SELECT * FROM account WHERE active = " . $status . "";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $row = $result->fetch_all();
        $data = [];
        foreach ($row as $cell) {
            array_push($data, array(
                'fullname' => $cell[3],
                'email' => $cell[0],
                'phoneNumber' => $cell[1],
                'address' => $cell[4],
                'dateOfBirth' => $cell[5],
                'idCard1' => $cell[6],
                'idCard2' => $cell[7],
                'active' => $cell[11],
                'wrongPasswordCount' => $cell[12],
                'obnormal' => $cell[13],
                'createdAt' => $cell[8],
                'updatedAt' => $cell[9],
                'deleted' => $cell[10],
            ));
        }
        return $data;
    }
}

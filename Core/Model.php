<?php
abstract class Model {
    protected $conn = null;
    public function __construct()
    {
        if (empty($this->conn)) {
            $this->conn = getDbConnection();
        }
    }
}
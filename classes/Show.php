<?php
require_once 'Connection.php';

class Show {
    public $id;
    public $start_time;
    public $end_time;
    public $stage_id;
    public $performer_id;

    public function __construct() {
    }

    public function save() {
        $params = array(
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'stage_id' => $this->stage_id,
            'performer_id' => $this->performer_id
        );

        if ($this->id === NULL) {
            $sql = "INSERT INTO shows(
                        start_time, end_time, stage_id, performer_id
                    ) VALUES (
                        :start_time, :end_time, :stage_id, :performer_id
                    )";
        }
        else if ($this->id !== NULL) {
            $params["id"] = $this->id;

            $sql = "UPDATE shows SET
                        start_time = :start_time,
                        end_time = :end_time,
                        stage_id = :stage_id,
                        performer_id = :performer_id
                    WHERE id = :id";
        }

        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to save show");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                throw new Exception("Error saving show");
            }
            if ($this->id === NULL) {
                $this->id = $conn->lastInsertId('shows');
            }
        }
    }

    public function delete() {
        if (empty($this->id)) {
            throw new Exception("Unsaved show cannot be deleted");
        }
        $params = array(
            'id' => $this->id
        );
        $sql = 'DELETE FROM shows WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to delete show");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                throw new Exception("Error deleting show");
            }
        }
    }

    public static function all() {
        $sql = 'SELECT * FROM shows';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute();
        if (!$success) {
            throw new Exception("Failed to retrieve shows");
        }
        else {
            $shows = $stmt->fetchAll(PDO::FETCH_CLASS, 'Show');
            return $shows;
        }
    }

    public static function find($id) {
        $params = array(
            'id' => $id
        );
        $sql = 'SELECT * FROM shows WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to retrieve show");
        }
        else {
            $show = $stmt->fetchObject('Show');
            return $show;
        }
    }
}
?>

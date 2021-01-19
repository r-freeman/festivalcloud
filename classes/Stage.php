<?php
require_once 'Connection.php';

class Stage {
    public $id;
    public $title;
    public $description;
    public $location;
    public $festival_id;
    public $image_path;

    public function __construct() {
    }

    public function save() {
        $params = array(
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'festival_id' => $this->festival_id,
            'image_path' => $this->image_path
        );

        if ($this->id === NULL) {
            $sql = "INSERT INTO stages(
                        title, description, location, festival_id, image_path
                    ) VALUES (
                        :title, :description, :location, :festival_id, :image_path
                    )";
        }
        else if ($this->id !== NULL) {
            $params["id"] = $this->id;

            $sql = "UPDATE stages SET
                        title = :title,
                        description = :description,
                        location = :location,
                        festival_id = :festival_id,
                        image_path = :image_path
                    WHERE id = :id";
        }

        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to save stage");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                throw new Exception("Error saving stage");
            }
            if ($this->id === NULL) {
                $this->id = $conn->lastInsertId('stages');
            }
        }
    }

    public function delete() {
        if (empty($this->id)) {
            throw new Exception("Unsaved stage cannot be deleted");
        }
        $params = array(
            'id' => $this->id
        );
        $sql = 'DELETE FROM stages WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to delete stage");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                throw new Exception("Error deleting stage");
            }
        }
    }

    public static function all() {
        $sql = 'SELECT * FROM stages';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute();
        if (!$success) {
            throw new Exception("Failed to retrieve stages");
        }
        else {
            $stages = $stmt->fetchAll(PDO::FETCH_CLASS, 'Stage');
            return $stages;
        }
    }

    public static function find($id) {
        $params = array(
            'id' => $id
        );
        $sql = 'SELECT * FROM stages WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to retrieve stage");
        }
        else {
            $stage = $stmt->fetchObject('Stage');
            return $stage;
        }
    }
}
?>

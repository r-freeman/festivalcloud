<?php
require_once 'Connection.php';

class Performer {
    public $id;
    public $title;
    public $description;
    public $contact_email;
    public $contact_phone;
    public $image_path;

    public function __construct() {
    }

    public function save() {
        $params = array(
            'title' => $this->title,
            'description' => $this->description,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'image_path' => $this->image_path
        );

        if ($this->id === NULL) {
            $sql = "INSERT INTO performers(
                        title, description, contact_email, contact_phone, image_path
                    ) VALUES (
                        :title, :description, :contact_email, :contact_phone, :image_path
                    )";
        }
        else if ($this->id !== NULL) {
            $params["id"] = $this->id;

            $sql = "UPDATE performers SET
                        title = :title,
                        description = :description,
                        contact_email = :contact_email,
                        contact_phone = :contact_phone,
                        image_path = :image_path
                    WHERE id = :id";
        }

        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to save performer");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                throw new Exception("Error saving performer");
            }
            if ($this->id === NULL) {
                $this->id = $conn->lastInsertId('performers');
            }
        }
    }

    public function delete() {
        if (empty($this->id)) {
            throw new Exception("Unsaved performer cannot be deleted");
        }
        $params = array(
            'id' => $this->id
        );
        $sql = 'DELETE FROM performers WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to delete performer");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                throw new Exception("Error deleting performer");
            }
        }
    }

    public static function all() {
        $sql = 'SELECT * FROM performers';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute();
        if (!$success) {
            throw new Exception("Failed to retrieve performers");
        }
        else {
            $performers = $stmt->fetchAll(PDO::FETCH_CLASS, 'Performer');
            return $performers;
        }
    }

    public static function find($id) {
        $params = array(
            'id' => $id
        );
        $sql = 'SELECT * FROM performers WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to retrieve performer");
        }
        else {
            $performer = $stmt->fetchObject('Performer');
            return $performer;
        }
    }
}
?>

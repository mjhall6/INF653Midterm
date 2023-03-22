<?php
    class Category {
        // DB stuff
        private $conn;
        private $table = 'categories';

        // Category Properties
        public $id;
        public $category;

        // Constructor with DB

        public function __construct($db){
            $this->conn = $db;
        }

        // Get Categories
        public function read() {
            // Create Query
            $query = 'SELECT 
                    id,
                    category
                FROM
                    ' . $this->table . ' 
                ORDER BY
                    id';
            
            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Execute query
            $stmt->execute();
            
            return $stmt;
        }

        // Get Single Category
        public function read_single() {
            // Create query
            $query = 'SELECT 
            id,
            category
            FROM
                ' . $this->table . ' 
            WHERE
                id = ?
            LIMIT 1';

            // Prepare statment
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                echo json_encode(
                    array('message' => 'category_id not found')
                );
            }

            // Set properties
            $this->id = $row['id'];
        }

            // Create Category
            public function create(){
                // Create Query
                $query = 'INSERT INTO ' . 
                    $this->table . '
                    SET
                       category_id = :category_id,
                       id = :id';

                // Prepare Statement
                $stmt = $this->conn->prepare($query);

                //Clean data
                $this->category = htmlspecialchars(strip_tags($this->category));
                $this->id = htmlspecialchars(strip_tags($this->id));

                // Bind data
                $stmt->bindParam(':category', $this->category);
                $stmt->bindParam(':id', $this->id);

                // Execute query
                if($stmt->execute()) {
                    return true;
                }
                
                // Print error if something goes wrong
                printf("Error: %s.\n, $stmt->error");

                return false;
            }

            
            // Update Category
            public function update(){
                // Create Query
                $query = 'UPDATE ' . 
                    $this->table . '
                    SET
                       category = :category,
                       id = :id
                    WHERE
                        id = :id';

                // Prepare Statement
                $stmt = $this->conn->prepare($query);

                //Clean data
                $this->category = htmlspecialchars(strip_tags($this->category));
                $this->id = htmlspecialchars(strip_tags($this->id));

                // Bind data
                $stmt->bindParam(':category', $this->category);
                $stmt->bindParam(':id', $this->id);

                // Execute query
                if($stmt->execute()) {
                    return true;
                }
                
                // Print error if something goes wrong
                printf("Error: %s.\n, $stmt->error");

                return false;
            }

            // Delete Category
            public function delete() {
                //Create query
                $query = 'DELETE FROM' . $this->table . 'WHERE id =:id';

                // Prepare Statement
                $stmt = $this->conn->prepare($query);

                // Clean data
                $this->id = htmlspecialchars(strip_tags($this->id));

                // Bind data
                $stmt->bindParam(':id', $this->id);

                // Execute query
                if($stmt->execute()) {
                    return true;
                }
                
                // Print error if something goes wrong
                printf("Error: %s.\n, $stmt->error");

                return false;
            }
    }
?>
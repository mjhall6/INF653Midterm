<?php
    class Author {
        // DB stuff
        private $conn;
        private $table = 'authors';

        // Author Properties
        public $id;
        public $author;

        // Constructor with DB

        public function __construct($db){
            $this->conn = $db;
        }

        // Get Author
        public function read() {
            // Create Query
            $query = 'SELECT 
                    id,
                    author
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

        // Get Single Author
        public function read_single() {
            // Create query
            $query = 'SELECT 
            id,
            author
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
                return false;
            }

            // Set properties
            $this->id = $row['id'];
        }

            // Create Author
            public function create(){
                // Create Query
                $query = 'INSERT INTO ' . 
                    $this->table . '
                    SET
                       author_id = :author_id,
                       id = :id';

                // Prepare Statement
                $stmt = $this->conn->prepare($query);

                //Clean data
                $this->author = htmlspecialchars(strip_tags($this->author));
                $this->id = htmlspecialchars(strip_tags($this->id));

                // Bind data
                $stmt->bindParam(':author', $this->author);
                $stmt->bindParam(':id', $this->id);

                // Execute query
                if($stmt->execute()) {
                    return true;
                }
                
                // Print error if something goes wrong
                printf("Error: %s.\n, $stmt->error");

                return false;
            }

            
            // Update Author
            public function update(){
                // Create Query
                $query = 'UPDATE ' . 
                    $this->table . '
                    SET
                       author = :author,
                       id = :id
                    WHERE
                        id = :id';

                // Prepare Statement
                $stmt = $this->conn->prepare($query);

                //Clean data
                $this->author = htmlspecialchars(strip_tags($this->author));
                $this->id = htmlspecialchars(strip_tags($this->id));

                // Bind data
                $stmt->bindParam(':author', $this->author);
                $stmt->bindParam(':id', $this->id);

                // Execute query
                if($stmt->execute()) {
                    return true;
                }
                
                // Print error if something goes wrong
                printf("Error: %s.\n, $stmt->error");

                return false;
            }

            // Delete Author
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
<?php
    class Quote {
        // DB stuff
        private $conn;
        private $table = 'quotes';

        // Quote Properties
        public $id;
        public $author_id;
        public $author;
        public $quote;
        public $category_id;
        public $category;

        // Constructor with DB

        public function __construct($db){
            $this->conn = $db;
        }

        // Get Quotes
        public function read() {
            // Create Query
            $query = 'SELECT 
                    c.category as category,
                    q.id,
                    q.category_id,
                    q.author_id,
                    q.quote
                FROM
                    ' . $this->table . ' q
                LEFT JOIN
                    categories c ON q.category_id = c.id
                ORDER BY
                    q.id';
            
            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Execute query
            $stmt->execute();
            
            return $stmt;
        }

        // Get Single Quote
        public function read_single() {
            // Create query
            $query = 'SELECT 
            c.category as catergory_id,
            q.id,
            q.category_id,
            q.author_id,
            q.quote
            FROM
                ' . $this->table . ' q
            LEFT JOIN
                categories c ON q.category_id = c.id
            WHERE
                q.id = ?
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
                    array('message' => 'author_id not found')
                );
            }

            // Set properties
            $this->author_id = $row['author_id'];
            $this->quote = $row['quote'];
            $this->category_id = $row['category_id'];
        }

            // Create Quote
            public function create(){
                // Create Query
                $query = 'INSERT INTO ' . 
                    $this->table . '
                    SET
                       author_id = :author_id,
                       quote = :quote,
                       category_id = :category_id,
                       id = :id';

                // Prepare Statement
                $stmt = $this->conn->prepare($query);

                //Clean data
                $this->author_id = htmlspecialchars(strip_tags($this->author_id));
                $this->quote = htmlspecialchars(strip_tags($this->quote));
                $this->category_id = htmlspecialchars(strip_tags($this->category_id));
                $this->id = htmlspecialchars(strip_tags($this->id));

                // Bind data
                $stmt->bindParam(':author_id', $this->author_id);
                $stmt->bindParam(':quote', $this->quote);
                $stmt->bindParam(':category_id', $this->category_id);
                $stmt->bindParam(':id', $this->id);

                // Execute query
                if($stmt->execute()) {
                    return true;
                }
                
                // Print error if something goes wrong
                printf("Error: %s.\n, $stmt->error");

                return false;
            }

            
            // Update Quote
            public function update(){
                // Create Query
                $query = 'UPDATE ' . 
                    $this->table . '
                    SET
                       author_id = :author_id,
                       quote = :quote,
                       category_id = :category_id,
                       id = :id
                    WHERE
                        id = :id';

                // Prepare Statement
                $stmt = $this->conn->prepare($query);

                //Clean data
                $this->author_id = htmlspecialchars(strip_tags($this->author_id));
                $this->quote = htmlspecialchars(strip_tags($this->quote));
                $this->category_id = htmlspecialchars(strip_tags($this->category_id));
                $this->id = htmlspecialchars(strip_tags($this->id));

                // Bind data
                $stmt->bindParam(':author_id', $this->author_id);
                $stmt->bindParam(':quote', $this->quote);
                $stmt->bindParam(':category_id', $this->category_id);
                $stmt->bindParam(':id', $this->id);

                // Execute query
                if($stmt->execute()) {
                    return true;
                }
                
                // Print error if something goes wrong
                printf("Error: %s.\n, $stmt->error");

                return false;
            }

            // Delete Quote
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

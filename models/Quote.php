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
                    a.author as author,
                    c.category as category,
                    q.id,
                    q.category_id,
                    q.author_id,
                    q.quote
                FROM
                    ' . $this->table . ' q
                INNER JOIN
                    categories c ON q.category_id = c.id
                INNER JOIN
                    authors a ON q.author_id = a.id
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
            //removed the _id lines for testing purposes below
            $query = 'SELECT 
                    a.author as author,
                    c.category as category,
                    q.id,
                    q.quote
                FROM
                    ' . $this->table . ' q
                INNER JOIN
                    categories c ON q.category_id = c.id
                INNER JOIN
                    authors a ON q.author_id = a.id
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
                    array('message' => 'No Quotes Found')
                );
                exit();
            }

            // Set properties
            $this->author = $row['author'];
            $this->quote = $row['quote'];
            $this->category = $row['category'];
        }

            // Create Quote
            public function create(){
                // Create Query
                $query = 'INSERT INTO ' . 
                    $this->table . '
                    VALUES(
                       :author_id,
                       :quote,
                       :category_id,
                       :id)';

                // Prepare Statement
                $stmt = $this->conn->prepare($query);

                //Clean data
                $this->author_id = htmlspecialchars(strip_tags($this->author_id));
                $this->quote = htmlspecialchars(strip_tags($this->quote));
                $this->category_id = htmlspecialchars(strip_tags($this->category_id));
                

                // Bind data
                $stmt->bindParam(':author_id', $this->author_id);
                $stmt->bindParam(':quote', $this->quote);
                $stmt->bindParam(':category_id', $this->category_id);
                

                // Execute query
                if($stmt->execute()) {
                    return true;
                }
                
                // Print error if something goes wrong
                printf("Error: %s.\n, $stmt->error");

                return false;

                if($category->category != null) {
                    $category_arr = array(
                        'id' => $categories->id,
                        'category' => $categories->category
                    );

                    echo json_encode($category_arr);
                } else {
                    echo json_encode( array(
                        'message' => 'category_id Not Found'
                        )
                    );
                }
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

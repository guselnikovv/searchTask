<?php


    class Db
    {

        public $db;

        public function __construct()
        {
            $config = (include __DIR__ . '/config.php')['db'];
            $this->db = new \PDO('mysql:host=' . $config['host']. ';dbname=' .$config['dbname'] .';charset=utf8mb4',
                $config['user'],
                $config['password']
            );
        }

        public function search($search)
        {
            $stmt = $this->db->query("SELECT a.title, c.body FROM `articles` a INNER JOIN comments c ON c.postId = a.id WHERE MATCH (c.body) AGAINST ('$search')");
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($row){
                foreach ($row as $comment){
                        $bl .= '<div class="card col-md-8" >
                                <div class="card-body">
                                    <h5 class="card-title">'.$comment['title'].'</h5>
                                    <p class="card-text">'.$comment['body'].'</p>
                                </div>
                            </div>';
                    }
                    return $bl;
                } else return "Поиск не дал результатов!";

            }

    }
<?php


    class CreateDb extends Db
    {
        public function __construct()
        {
            parent::__construct();
            $sql = "SHOW TABLES LIKE 'articles' ";
            $stmt = $this->db->query($sql);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if($res === false) {
                $sql = "CREATE TABLE `articles` (
                  `userId` int(11) NOT NULL,
                  `id` int(11) NOT NULL,
                  `title` varchar(255) NOT NULL,
                  `body` text NOT NULL
                )";

                $stmt = $this->db->query($sql);
                if($stmt === false) return "Ошибка создания таблицы articles";
                else echo "<br> Таблица articles создана!";
            }

            $sql = "SHOW TABLES LIKE 'comments' ";
            $stmt = $this->db->query($sql);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if($res === false) {
                $sql = "CREATE TABLE `comments` (
                  `postId` int(11) NOT NULL,
                  `id` int(11) NOT NULL,
                  `email` varchar(255) NOT NULL,
                  `body` text NOT NULL
                )";

                $stmt = $this->db->query($sql);
                if($stmt === false) return "Ошибка создания таблицы comments";
                else echo "<br> Таблица comments создана!";

                $sql = "ALTER TABLE `comments` ADD FULLTEXT KEY `body_ft` (`body`)";
                $stmt = $this->db->query($sql);
                if($stmt === false) return "Ошибка создания индекса fulltext";
                else echo "<br> Индекс создан.";

            }

            $f_json = 'https://jsonplaceholder.typicode.com/posts';
            $json = file_get_contents("$f_json");
            $json_arr = json_decode($json, true);

            $article_count = 0;
            foreach ($json_arr as $item){
                $userId = $item['userId'];
                $id = $item['id'];
                $title = $item['title'];
                $body = $item['body'];
                $stmt = $this->db->query("INSERT INTO articles (userId, id, title, body) VALUES ($userId,
                $id, '$title', '$body')");
                if($stmt) {
                    $article_count++;
                } else echo "Ошибка добавления article userId:$userId id: $id title:$title body:$body";
            }
            echo "<br> Добавлено статей <b>$article_count</b>";

            $f_json = 'https://jsonplaceholder.typicode.com/comments';
            $json = file_get_contents("$f_json");
            $json_arr = json_decode($json, true);

            $comments_count = 0;
            foreach ($json_arr as $item){
                $postId = $item['postId'];
                $id = $item['id'];
                $email = $item['email'];
                $body = $item['body'];
                $stmt = $this->db->query("INSERT INTO comments (postId, id, email, body) VALUES ($postId,
                $id, '$email', '$body')");
                if($stmt) {
                    $comments_count++;
                } else echo "Ошибка добавления article userId:$postId id: $id title:$email body:$body";
            }
            echo "<br> Добавлено комментариев <b>$comments_count</b>";

        }
    }
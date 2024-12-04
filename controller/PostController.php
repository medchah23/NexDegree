<?php
include_once(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/Post.php');

class PostController
{
    public function listPOSTS()
    {
        $sql = "SELECT posts.post_id, posts.title, posts.content, posts.created_at, posts.user_id, 
                       comments.comment_id, comments.content AS comment_content, comments.created_at AS comment_date 
                FROM posts 
                LEFT JOIN comments ON posts.post_id = comments.post_id";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            $posts = $liste->fetchAll(PDO::FETCH_ASSOC); 
            $postsList = [];

            // Grouping comments under each post
            foreach ($posts as $post) {
                // Check if the post already exists in the array
                if (!isset($postsList[$post['post_id']])) {
                    $postsList[$post['post_id']] = [
                        'post_id' => $post['post_id'],
                        'title' => $post['title'],
                        'content' => $post['content'],
                        'created_at' => $post['created_at'],
                        'user_id' => $post['user_id'],
                        'comments' => []
                    ];
                }
                // Add comment if it exists
                if ($post['comment_id']) {
                    $postsList[$post['post_id']]['comments'][] = [
                        'comment_id' => $post['comment_id'],
                        'content' => $post['comment_content'],
                        'created_at' => $post['comment_date']
                    ];
                }
            }
            return array_values($postsList); // Return posts with comments
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function deletePost($id)
    {
        $sql = "DELETE FROM posts WHERE post_id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function addPost($post)
    {   
        var_dump($post);
        $sql = "INSERT INTO posts (title, content, created_at, user_id) VALUES (:title, :content, :created_at, :user_id)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
                'user_id' => $post->getUserId()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function updatePost($post, $id)
    {
        var_dump($post);
        try {
            $db = config::getConnexion();

            $query = $db->prepare(
                'UPDATE posts SET 
                    title = :title,
                    content = :content,
                    created_at = :created_at
                WHERE post_id = :id'
            );

            $query->execute([
                'id' => $id,
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); 
        }
    }

    function showPost($id)
    {
        $sql = "SELECT posts.post_id, posts.title, posts.content, posts.created_at, posts.user_id, 
                       comments.comment_id, comments.content AS comment_content, comments.created_at AS comment_date 
                FROM posts 
                LEFT JOIN comments ON posts.post_id = comments.post_id
                WHERE posts.post_id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();

            $post = $query->fetchAll();
            $postWithComments = [
                'post' => [],
                'comments' => []
            ];

            foreach ($post as $row) {
                $postWithComments['post'] = [
                    'post_id' => $row['post_id'],
                    'title' => $row['title'],
                    'content' => $row['content'],
                    'created_at' => $row['created_at'],
                    'user_id' => $row['user_id']
                ];

                if ($row['comment_id']) {
                    $postWithComments['comments'][] = [
                        'comment_id' => $row['comment_id'],
                        'content' => $row['comment_content'],
                        'created_at' => $row['comment_date']
                    ];
                }
            }

            return $postWithComments;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>

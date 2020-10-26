<?php 
class POST {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }
    //define the standard query for the posts feed
    Private $generateFeed = 'SELECT 
    post.id, 
    post.subscriber_id, 
    post.body, 
    post.created_at, 
    post.upvote_count, 
    subscriber.name ,
    subscriber.handle,
    subscriber.photo_name
    FROM post JOIN subscriber ON post.subscriber_id = subscriber.id '; 

Private $generateReplies = 'SELECT 
    reply.id, 
    reply.subscriber_id, 
    reply.body, 
    reply.post_id,
    reply.created_at, 
    reply.upvote_count, 
    subscriber.name ,
    subscriber.handle,
    subscriber.photo_name
    FROM reply JOIN subscriber ON reply.subscriber_id = subscriber.id '; 

    private $postOrder = 'ORDER BY post.created_at DESC LIMIT 30';
    
//Query, Bind, Return

    public function postsByAuthor($subscriber){

      $this->db->query('SELECT * FROM post WHERE subscriber_id = :subscriber');
      $this->db->bind(':subscriber', $subscriber);
      return $this->db->resultSetAssoc();
    }

    public function postsBySearchTerm($search){

      $this->db->query( $this->generateFeed . "WHERE body LIKE :search " . $this->postOrder);
      $this->db->bind(':search', $search);
      return $this->db->resultSetAssoc();
    }


    public function postsByAll(){
      $this->db->query($this->generateFeed . $this->postOrder);
      return $this->db->resultSetAssoc();
    }
      // Likes by user
      public function upvotesByUser($data){

        $this->db->query('SELECT post_id FROM post_upvote WHERE subscriber_id = :user');
        $this->db->bind(':user', $data);
        return $this->db->resultSetAssoc();
      }

      public function upvotesRepliesByUser($data){

        $this->db->query('SELECT reply_id FROM reply_upvote WHERE subscriber_id = :user');
        $this->db->bind(':user', $data);
        return $this->db->resultSetAssoc();
      }

      private $postUpdate = 'INSERT INTO `post_upvote` (`post_id`, `subscriber_id`) VALUES( :post_id, :subscriber_id)';
      private $replyUpdate = 'INSERT INTO `reply_upvote` (`reply_id`, `subscriber_id`) VALUES( :post_id, :subscriber_id)';
      private $postUpdateIncrement = 'UPDATE post SET upvote_count = upvote_count + 1 WHERE id = :post_id';
      private $replyUpdateIncrement = 'UPDATE reply SET upvote_count = upvote_count + 1 WHERE id = :post_id';
      
      //Add likes - takes post_id and subscriber id 
      public function addPostUpvote($data){
        //set parameters to update either posts or replies
        if($data['update_type']==='post'){
          $updateType = $this->postUpdate;
          $updateTypeIncrement=$this->postUpdateIncrement;  
        }else{
          $updateType = $this->replyUpdate;
          $updateTypeIncrement=$this->replyUpdateIncrement;  
        }
        //Adds and entry to the post_upvote table
        $this->db->query($updateType);
        $this->db->bind(':post_id', $data['post_id']);
        $this->db->bind(':subscriber_id', $data['subscriber_id']);
        $this->db->execute(); 
        //Increments the upvote count in the post table, done so we can see likes without calling the upvote table all the time
        $this->db->query($updateTypeIncrement);
        $this->db->bind(':post_id', $data['post_id']);
        $this->db->execute(); 
      }
      private $postRemoveUpvote = 'DELETE FROM `post_upvote` WHERE `post_id` = :post_id AND `subscriber_id` = :subscriber_id';
      private $replyRemoveUpvote = 'DELETE FROM `reply_upvote` WHERE `reply_id` = :post_id AND `subscriber_id` = :subscriber_id';
      private $replyRemoveUpvoteIncrement = 'UPDATE reply SET upvote_count = upvote_count - 1 WHERE id = :post_id';
      private $postRemoveUpvoteIncrement = 'UPDATE post SET upvote_count = upvote_count - 1 WHERE id = :post_id';

      public function removePostUpvote($data){
        if($data['update_type']==='post'){
          $updateType = $this->postRemoveUpvote;
          $updateTypeIncrement=$this->postRemoveUpvoteIncrement;  
        }else{
          $updateType = $this->replyRemoveUpvote;
          $updateTypeIncrement=$this->replyRemoveUpvoteIncrement;  
        }
        $this->db->query($updateType);
        $this->db->bind(':post_id', $data['post_id']);
        $this->db->bind(':subscriber_id', $data['subscriber_id']);
        $this->db->execute(); 
        //Decrement the total likes in the post
        $this->db->query($updateTypeIncrement);
        $this->db->bind(':post_id', $data['post_id']);
        
        $this->db->execute(); 

    }
    
    public function addPost($data ){
      $this->db->query('INSERT INTO `post`( `subscriber_id`,`body`, `upvote_count`) VALUES (:subscriber, :body, :upvote)');
      $this->db->bind(':subscriber', $data['subscriber']);
      $this->db->bind(':body', $data['body']);
      $this->db->bind(':upvote', $data['upvote_count']);
      $this->db->execute(); 
    }
    
    Private $selectPost = 'WHERE post.id = :post';

    public function postByPostId($post){
      $this->db->query($this->generateFeed . $this->selectPost);
      $this->db->bind(':post', $post);
      return $this->db->SingleArray();
    }
    //reply query
    Private $selectReplies = 'WHERE reply.post_id = :post';
    public function repliesByPostId($post){
      $this->db->query($this->generateReplies . $this->selectReplies);
      $this->db->bind(':post', $post);
      return $this->db->resultSetAssoc();
    }
    public function addReply($data ){
      $this->db->query('INSERT INTO `reply`( `subscriber_id`,`body`, `post_id`,`upvote_count`) VALUES (:subscriber, :body, :post_id, :upvote)');
      $this->db->bind(':subscriber', $data['subscriber']);
      $this->db->bind(':body', $data['body']);
      $this->db->bind(':post_id', $data['post_id']);
      $this->db->bind(':upvote', $data['upvote_count']);
      $this->db->execute(); 
    }



    //Not used or tested yet
    public function deletePost($data){
    $this->db->query('DELETE FROM `post` WHERE `id` = :post');
    $this->db->bind(':post', $data['post']);
    $this->db->execute(); 
    }
} 
<?php

namespace Anax\MVC;

/**
 * To attach comments-flow to a question or to a response.
 *
 */
class CCommentModel implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
    * Add a new comment.
    *
    * @param array $comment with all details.
    * @param $key with comment page.
    *
    * @return void
    */
    public function add($comment, $key = null)
    {
        $type = $this->request->getGet('id');
        $comments = $this->session->get('comments', []);
        $comments[$key][] = $comment;
        $this->session->set('comments', $comments);
    }

    /**
    * Find and return all comments.
    *
    * @param $key with comment page.
    *
    * @return array with all comments.
    */
    public function findAll($key = null)
    {
      $this->db->select()
               ->from($this->getSource($key));
      $this->db->execute();
      $this->db->setFetchModeClass(__CLASS__);
      return $this->db->fetchAll();
    }

    /**
    * Find a comment.
    *
    * @param $id with comment id number.
    * @param $key with comment page.
    *
    * @return string with the comment.
    */
    public function find($id,$key = null)
    {
      $this->db->select()
               ->from($this->getSource($key))
               ->where("id = ?");

      $this->db->execute([$id]);
      return $this->db->fetchInto($this);
    }

    /**
    * edit a comment.
    *
    * @param array $comment with all details.
    * @param $id with comment id number.
    * @param $key with comment page.
    *
    * @return void
    */
    public function edit($comment,$id,$key = null)
    {
      $comments = $this->session->get('comments', []);
      $editedComment[$key][$id] = $comment;
      return $comment[$key][$id];
    }

    /**
    * edit a comment.
    *
    * @param array $comment with all details.
    * @param $id with comment id number.
    * @param $key with comment page.
    *
    * @return void
    */
    public function saveEdit($comment, $id,$key = null)
    {
      $comments = $this->session->get('comments', []);
      $comments[$key][$id] = $comment;
      $this->session->set('comments', $comments);
    }

    /**
     * Save current object/row.
     *
     * @param array $values key/values to save or empty to use object properties.
     *
     * @return boolean true or false if saving went okey.
     */
    public function saveToDB($values = [])
    {
        $this->setProperties($values);
        $values = $this->getProperties($values);
        if (isset($values['id'])) {
            return $this->update($values);
        } else {
            return $this->create($values);
        }
    }

    /**
     * Clear database
     *
     * @param array $values key/values to save or empty to use object properties.
     *
     * @return boolean true or false if saving went okey.
     */
    public function clearDb($key)
    {
      if($key==1) {
        $this->db->dropTableIfExists('comment')->execute();

        $this->db->createTable(
          'comment',
          [
              'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
              'content' => ['varchar(255)'],
              'name' => ['varchar(80)'],
              'email' => ['varchar(80)'],
              'web' => ['varchar(255)'],
              'timestamp' => ['datetime'],
              'ip' => ['varchar(80)'],
              'page' => ['varchar(10)'],
          ]
          )->execute();
      }
      else {
        $this->db->dropTableIfExists('comment2')->execute();

        $this->db->createTable(
          'comment2',
          [
              'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
              'content' => ['varchar(255)'],
              'name' => ['varchar(80)'],
              'email' => ['varchar(80)'],
              'web' => ['varchar(255)'],
              'timestamp' => ['datetime'],
              'ip' => ['varchar(80)'],
              'page' => ['varchar(10)'],
          ]
          )->execute();
      }
    }

    /**
   * Get object properties.
   *
   * @return array with object properties.
   */
    public function getProperties()
    {
        $properties = get_object_vars($this);
        unset($properties['di']);
        unset($properties['db']);

        return $properties;
    }

    /**
   * Set object properties.
   *
   * @param array $properties with properties to set.
   *
   * @return void
   */
    public function setProperties($properties)
    {
        // Update object with incoming values, if any
        if (!empty($properties)) {
            foreach ($properties as $key => $val) {
                $this->$key = $val;
            }
        }
    }

    /**
     * Create new row.
     *
     * @param array $values key/values to save.
     *
     * @return boolean true or false if saving went okey.
     */
    public function create($values)
    {
      $keys   = array_keys($values);
      $values = array_values($values);

      $this->db->insert(
          $this->getSource(),
          $keys
      );

      $res = $this->db->execute($values);

      $this->id = $this->db->lastInsertId();

      return $res;
    }


    /**
    * Update row.
    *
    * @param array $values key/values to save.
    *
    * @return boolean true or false if saving went okey.
    */
   public function update($values)
   {
       $keys   = array_keys($values);
       $values = array_values($values);

       // Its update, remove id and use as where-clause
       unset($keys['id']);
       $values[] = $this->id;

       $this->db->update(
           $this->getSource($values[6]),
           $keys,
           "id = ?"
       );

       return $this->db->execute($values);
   }

        /**
        * Get the table name.
        *
        * @return string with the table name.
        */
       public function getSource()
       {
           return 'Comments';
       }

    /**
    * delete a comment.
    *
    * @param $id with comment id number.
    * @param $key with comment page.
    *
    * @return void
    */
    public function delete($id,$key = null)
    {
      $this->db->delete(
          $this->getSource($key),
          'id ='.$id
      );

      return $this->db->execute([$id]);
    }

    /**
    * Delete all comments.
    *
    * @param $key with comment page.
    *
    * @return void
    */
    public function deleteAll($key = null)
    {
      $comments = $this->findAll();
      unset($comments[$key]);
      $this->session->set('comments', $comments);
    }

    /**
   * Build a select-query.
   *
   * @param string $columns which columns to select.
   *
   * @return $this
   */
  public function query($columns = '*')
  {
      $this->db->select($columns)
               ->from($this->getSource());
      return $this;
  }
}

<?php

namespace Anax\MVC;
/**
* Model for QuestionTag.
*
*/
class CQuestiontagModel implements \Anax\DI\IInjectionAware
{
  use \Anax\DI\TInjectable;

  /**
  * Build the where part.
  *
  * @param string $condition for building the where part of the query.
  *
  * @return $this
  */
  public function andWhere($condition)
  {
    $this->db->andWhere($condition);

    return $this;
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
* Delete row.
*
* @param integer $id to delete.
*
* @return boolean true or false if deleting went okey.
*/
public function delete($id)
{
  $this->db->delete(
  $this->getSource(),
  'Questionid = ?'
);

return $this->db->execute([$id]);
}

/**
* Find and return specific.
*
* @param integer $id.
*
* @return this
*/
public function find($id)
{
  $this->db->select()
  ->from($this->getSource())
  ->where("id = ?");

  $this->db->execute([$id]);
  return $this->db->fetchInto($this);
}

/**
* Find and return all.
*
* @return array
*/
public function findAll()
{
  $this->db->select()
  ->from($this->getSource());

  $this->db->execute();
  $this->db->setFetchModeClass(__CLASS__);
  return $this->db->fetchAll();
}

/**
* Find and return all response to a specific question.
*
* @param integer $id.
*
* @return array
*/
public function findAllResponses($id)
{
  $this->db->select("Response.Responsename")
  ->from("Question,Response,QuestionResponse")
  ->where("Question.Id=QuestionResponse.Questionid and Response.Id=QuestionResponse.Responseid and Question.Id = ?");

  $this->db->execute([$id]);
  $this->db->setFetchModeClass(__CLASS__);
  return $this->db->fetchAll();
}

/**
* Find and return all tags to a specific question.
*
* @param integer $id.
*
* @return array
*/
public function findAllTags($id)
{
  $this->db->select("Tag.Tagname")
  ->from("Question,Tag,QuestionTag")
  ->where("Question.Id=QuestionTag.Questionid and Tag.Id=QuestionTag.Tagid and Question.Id = ?");

  $this->db->execute([$id]);
  $this->db->setFetchModeClass(__CLASS__);
  return $this->db->fetchAll();
}

/**
* Find and return all latest questiontags.
*
* @return array
*/
public function findLatestrow()
{
  $this->db->select("Questionid")
           ->from("QuestionTag order by Questionid desc limit 1");

  $this->db->execute();
  $this->db->setFetchModeClass(__CLASS__);
  return $this->db->fetchAll();
}

/**
* Find and return most pupular tag, for firstpage.
*
* @return array
*/
public function findMostPopularTag()
{
  $this->db->select("*")
  ->from("QuestionTag group by Tagid order by count(*) desc limit 2");

  $this->db->execute();
  $this->db->setFetchModeClass(__CLASS__);
  return $this->db->fetchAll();
}

/**
* Execute the query built.
*
* @param string $query custom query.
*
* @return $this
*/
public function execute($params = [])
{
  $this->db->execute($this->db->getSQL(), $params);
  $this->db->setFetchModeClass(__CLASS__);

  return $this->db->fetchAll();
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
* Get the table name.
*
* @return string with the table name.
*/
public function getSource()
{
  return "QuestionTag";
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

/**
* Save current object/row.
*
* @param array $values key/values to save or empty to use object properties.
*
* @return boolean true or false if saving went okey.
*/
public function save($values = [])
{
  $this->setProperties($values);
  $values = $this->getProperties();

  if (isset($values['id'])) {
    return $this->update($values);
  } else {
    return $this->create($values);
  }
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
  $this->getSource(),
  $keys,
  "id = ?"
);

return $this->db->execute($values);
}

/**
* Build the where part.
*
* @param string $condition for building the where part of the query.
*
* @return $this
*/
public function where($condition)
{
  $this->db->where($condition);

  return $this;
}
}

<?php

class Book
{
    public $id = null;
    public $title = "";
    public $author = "";
    public $isbn = "";

public function load($id)
{
    global $mysqli;

    $query = "SELECT * FROM mvc_boeken WHERE id = " . $id;

    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) == 1)
    {
        $row = mysqli_fetch_array($result);

        $this->id = $id;
        $this->title = $row['title'];
        $this->author = $row['author'];
        $this->isbn = $row['isbn'];
    }
    else
    {
        throw new Exception("Kan het boek met id {$id} niet vinden.");
    }
}

public function saveNew()
{
    global $mysqli;

    if (is_null($this->id)) //Will only run if id is null which means that an id is available
    {
    if (strlen($this->title) > 0 && strlen($this->author) > 0 && strlen($this->isbn) > 0)
    {
        $this->title = mysqli_real_escape_string($mysqli, $this->title);
        $this->author = mysqli_real_escape_string($mysqli, $this->author);
        $this->isbn = mysqli_real_escape_string($mysqli, $this->isbn);
    
        $query = "INSERT INTO mvc_boeken (title, author, isbn)";
        $query .= "VALUES ('{$this->title}', '{$this->author}', '{$this->isbn}')";
    
        if (mysqli_query($mysqli, $query))
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
}
    return false; //will not run if id already exists
}

public function showAll()
{
    global $mysqli;

    $boeken = Array();

    $result = mysqli_query($mysqli, "SELECT id FROM mvc_boeken ORDER BY id");

    if (mysqli_num_rows($result)>0)
    {
        while ($row = mysqli_fetch_array($result))
        {
            $bookAdd = new Book();
            $bookAdd->load($row['id']);
            $boeken[] = $bookAdd;
        }
    }
    return $boeken;
}

public function delete()
{
    global $mysqli;
    if (!is_null($this->id))
    {
        $query = "DELETE FROM mvc_boeken WHERE id = " . $this->id;
        if (mysqli_query($mysqli, $query))
        {
            return true;
        }
    }
    return false;
}

public function update()
{
    global $mysqli;

    if (!is_null($this->id))
    {
        $this->title = mysqli_real_escape_string($mysqli, $this->title);
        $this->author = mysqli_real_escape_string($mysqli, $this->author);
        $this->isbn = mysqli_real_escape_string($mysqli, $this->isbn);

        $query = "UPDATE mvc_boeken ";
        $query .= "SET title = '{$this->title}', author = '{$this->author}', isbn = '{$this->isbn}' ";
        $query .= "WHERE id = {$this->id}";

        if (mysqli_query($mysqli, $query))
        {
            return true;
        }
        else
        {
            echo $query . "<br/>";
            echo mysqli_error($mysqli);
        }
    }
    return false;
}
}
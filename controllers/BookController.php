<?php

class BookController
{
    private $book;

    public function __construct()
    {
        $this->book = new Book();
    }

    public function index()
    {
        $boekenArray = $this->book->showAll();
        include "./views/bookList.php";
    }

    public function showBook($id)
{
    if (!is_null($id))
    {
        $this->book->load($id);
    }
    $boek = $this->book;
    include "./views/bookDetails.php";
}

public function newBook($titel, $auteur, $isbn)
{
        $this->book->title = htmlentities($titel);
        $this->book->author = htmlentities($auteur);
        $this->book->isbn = htmlentities($isbn);
        if (strlen($this->book->title) > 0 && strlen($this->book->author) > 0 && ($this->book->isbn) > 0)
        {
            if($this->book->saveNew())
            {
                $result = $this->book->title . " is toegevoegd!";
                include "../views/newBookResult.php";
            }
            else
            {
                $result = "FOUT bij toevoegen " . $this->book->title;
            }
        }
        else
        {
            $result = "Niet alle eigenschappen gevuld";
        }   
    }

public function deleteBook($id)
{
    if(!is_null($id))
    {
        $this->book->load($id);

        if($this->book->delete())
        {
            $result = "Boek met id {$id} is verwijderd.";
        }
        else
        {
            $result = "FOUT bij verwijderen van boek met id {$id} ";
        }
    }
    else
    {
        $result = "Boek met id {$id} is niet gevonden.";
    }
    include "../views/deleteBookResult.php";
}

public function showUpdateForm($id)
{
    if (!is_null($id))
    {
        $this->book->load($id);
        $boek = $this->book;
        include "./views/updateBookForm.php";
    }
}

public function updateBook($id, $titel, $auteur, $isbn)
{
    $result = "";

    $this->book->id = $id;
    $this->book->title = htmlentities($titel);
    $this->book->author = htmlentities($auteur);
    $this->book->isbn = htmlentities($isbn);

    if (($this->book->isbn) >= 0 && strlen($this->book->title) > 0 && strlen($this->book->author) > 0 && ($this->book->isbn) > 0)
    {
        if($this->book->update())
        {
            $result = $this->book->title . " is aangepast!";
        }
        else
        {
            $result = "FOUT bij aanpassen " . $this->book->title;
        }
    }
    else
    {
        $result = "Niet alle eigenschappen gevuld";
    }
    include "../views/updateBookResult.php";
}
}
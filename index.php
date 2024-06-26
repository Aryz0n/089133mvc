<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>VerdProg: Boekenapplicatie</title>
</head>
<body>
  <h3><a href="?voegtoe">voegtoe</a></h3>

<?php
require 'inc/config.inc.php';
require 'models/Book.php';
require 'controllers/BookController.php';

$ctr = new BookController();

if (isset($_GET['verwijder']))
{
  $ctr->deleteBook($_GET['verwijder']);
}

if (isset($_GET['pasaan']))
{
    if (isset($_POST['aanpasKnop']))
    {
      $ctr->updateBook($_POST['id'], $_POST['titel'], $_POST['auteur'], $_POST['isbn']);
    }

    else
    {
    ?>
      <h3>Boek aanpassen:</h3>
      <form method="post" action="">
        <p>ID:<input type="hidden" name="id" value="<?= $_GET['pasaan'] ?>" required/></p>
        <p>Titel:<input type="text" name="titel" required/></p>
        <p>Auteur:<input type="text" name="auteur" required/></p>
        <p>ISBN:<input type="number" name="isbn" required/></p>
        <p><input type="submit" name="aanpasKnop" value="PAS AAN"/></p>
      </form>
    <?php
    }
}

if (isset($_GET['voegtoe']))
{
  if (isset($_POST['knop']))
  {
    $ctr->newBook($_POST['titel'], $_POST['auteur'], $_POST['isbn']);
  }
  else
  {
  ?>
    <h3>Boek toevoegen:</h3>
    <form method="post" action="">
      <p>Titel:<input type="text" name="titel" required/></p>
      <p>Auteur:<input type="text" name="auteur" required/></p>
      <p>ISBN:<input type="number" name="isbn" required/></p>
      <p><input type="submit" name="knop" value="VOEG TOE"/></p>
    </form>
  <?php
  }
}

if (isset($_GET['id']))
{
  $ctr->showBook($_GET['id']);
}
else
{
  $ctr->index();
}
?>
<br>
<a href='./index.php'>Refresh</a>
</body>
</html>
<?php
$insert = false;
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$database);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST['snoedit'])){
    $sno = $_POST['snoedit'];
    $title=$_POST['titleedit'];
    $description = $_POST['descriptionedit'];
    $sql = "UPDATE `notes` SET `title` = '$title' ,`description` = '$description' WHERE `notes`.`sno` = $sno";
    $result =mysqli_query($conn,$sql);

  }else{
  $title=$_POST['title'];
  $description = $_POST['description'];
  $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title','$description')";

if (mysqli_query($conn, $sql)) {
  // echo "New record created successfully";
  $insert=true;
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keep Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
  </head>
  <body>
    <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit Note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/PHP/ToDo.php" method ="Post">
          <input type="hidden" name=snoedit id=snoedit>  
          <div class="mb-3">
            <label for="title" class="form-label">Note Title</label>
            <input type="text" class="form-control" id="titleedit" name="titleedit" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3">
            
          <label for="Desc" class="form-label">Note Description</label>
          <textarea class="form-control" id="descriptionedit" name="descriptionedit" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


  <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ToDo App</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<?php
if($insert){
  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>Success</strong> Your note has been added.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";

}
?>
  <div class="container">
  <h1>Add a Note</h1>
  <form action="/PHP/TODo.php" method ="Post">
  <div class="mb-3">
    <label for="title" class="form-label">Note Title</label>
    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    
  <label for="Desc" class="form-label">Note Description</label>
  <textarea class="form-control" id="description" name="description" rows="3"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Add Note</button>
</form>
</div>
<div class="container">
<table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $sql = "SELECT * FROM `notes`";
  $result = mysqli_query($conn,$sql);
  $sno=0;
  while($row = mysqli_fetch_assoc($result)){
    $sno=$sno+1;
    echo "<tr>
    <th scope='row'>".$sno."</th>
    <td>".$row['title']."</td>
    <td>".$row['description']."</td>
    <td> <button class='edit btn btn-sm  btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button></td>
  </tr>";
    // echo $row['sno'].$row['title'] . $row['description'];
    // echo "<br>";
  };
  ?>
  
  </tbody>
</table>
  
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

    <script>
      let table = new DataTable('#myTable');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach(element=>{
        element.addEventListener('click',(e)=>{
          console.log("edit");
          tr=e.target.parentNode.parentNode;
          title=tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title,description);
          titleedit.value = title;
          descriptionedit.value = description;
          snoedit.value = e.target.id;
          console.log(e.target.id);
          $( '#editModal').modal('toggle');
        })
      })

      deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `/PHP/ToDo.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
      })
    })
    </script>
   
    
  </body>
</html>
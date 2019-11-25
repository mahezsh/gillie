<HTML XMLns="http://www.w3.org/1999/xHTML">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
      $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>
<body>
<H1>Photo Album</H1>

<b>Search</b>
<form action="getphotos.php" method="POST">
  Title: <input type="text" name="searchTitle"><br><br>
    keywords: <input type="text" name="searchkeywords"><br><br>
    Start Date: <input type="text" name="searchDateStart" id="datepicker1"><br><br>
    End Date: <input type="text" name="searchDateEnd" id="datepicker2"><br><br>
    <input type='submit' value='Search' name='update' />
</form>


<?php
if(isset($_POST['update']) && $_POST['update']!="")
  {

    $DBConnect = @mysqli_connect("gillie-db.c1x7jt5kkcd5.ap-southeast-2.rds.amazonaws.com", "master","master123", "gilliedb")
    Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ". mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";

    $title = $_POST['searchTitle'];
        $keywords = $_POST['searchkeywords'];
        $start = $_POST['searchDateStart'];
        $end = $_POST['searchDateEnd'];


       // $SQLstring = "SELECT photo_title, description, date_of_photo, keywords, reference FROM photos";


        $or_where = [];
        if(!empty($title)){
            $or_where [] =" photo_title  = '" . $title . "'";
        }
        if(!empty($keywords)){
            $keywords_arr = explode(',',$keywords);
            foreach($keywords_arr as $keyword){
              $or_where [] =" keywords LIKE '%" . trim($keyword) . "%' ";
            }

        }

        if(!empty($start) && !empty($end)  ){
          $or_where [] = " (date_of_photo BETWEEN '" . $start . "' and '" . $end . "') ";
        }else if(!empty($start)){
          $or_where [] = " ( date_of_photo >= '" . $start . "' ) ";

        }else if(!empty($end) ){
          $or_where [] = " ( date_of_photo <= '" . $end . "' ) ";
        }

        if(empty($or_where)){
             $SQLstring = "SELECT photo_title, description, date_of_photo, keywords, reference FROM photos ";

        }else{
             $SQLstring = "SELECT photo_title, description, date_of_photo, keywords, reference FROM photos WHERE  ".implode(' OR ',$or_where);
        }


    $queryResult = @mysqli_query($DBConnect, $SQLstring)
    Or die ("<p>Unable to query the database tables.</p>"."<p>Error code ". mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";

    echo "<table width='100%' border='1'>";
    echo "<th>Photo Title</th><th>Description</th><th>Date of photo</th><th>keywords</th><th>Reference</th>";
    $row = mysqli_fetch_row($queryResult);
    while ($row)
    {
      echo "<tr><td>{$row[0]}</td>";
            echo "<td>{$row[1]}</td>";
            echo "<td>{$row[2]}</td>";
            echo "<td>{$row[3]}</td>";
            echo "<td><img src='{$row[4]}' height='200' width='200'></td></tr>";
      $row = mysqli_fetch_row($queryResult);
    }
    echo "</table>";

    mysqli_close($DBConnect);

  }
?>

</body>
</HTML>

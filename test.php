<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>change demo</title>
  <style>
  div {
    color: red;
  }
  </style>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
 
<select name="lang" id="lang">
  <option>Language</option>
  <option value="en">English</option>
  <option value="hin">Hindi</option>
</select>
<div id="form"></div>
 
<script>
$( "select" )
  .change(function () {
    var str = "";
    $( "select option:selected" ).each(function() {
      str = $( this ).text();
    });
   $( "#form" ).text(str);
  })
  
</script>
 
</body>
</html>


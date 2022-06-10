<?php 
print_r($_POST);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Full Page Editing &mdash; CKEditor Sample</title>
	<script src="ckeditor/ckeditor.js"></script>
	
</head>
<body>
	
		
	<form action="" method="post">
		
		<textarea cols="80" id="editor1" name="editor1" rows="10">
			
		</textarea>
		<script>

			CKEDITOR.replace( 'editor1');

		</script>
		<p>
			<input type="submit" value="Submit">
		</p>
	</form>
	
</body>
</html>

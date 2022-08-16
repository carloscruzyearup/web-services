<html>
<head>
<title>RPDR Web Service Demo</title>
<style>
	body {font-family:georgia;}

  .season{
	border:2px solid aquamarine;
	padding: 5px;
	margin-bottom: 5px;
  }

  .pic{
	position: absolute;
	right: 10px;
	top: 10px;
  }

  .pic img{ /*ensures thumbnail width is at 50px*/
	max-width: 50px;
  }



</style>
<script src="https://code.jquery.com/jquery-latest.js"></script>

<script type="text/javascript">

function albumTemplate(album){
	return `
		<div class="album">
			<b>Number</b>: ${album.Number}<br/>
			<b>Year</b>: ${album.Year}<br/>
			<b>Album</b>: ${album.Album}<br/>
			<b>Artist</b>: ${album.Artist}<br/>
			<b>Genre</b>: ${album.Genre}<br/>
			<b>Subgenre</b>: ${album.Subgenre}<br/>
			<div class="pic"><img src="thumbnails/${album.Image}"/></div>
		</div> 
  `; //put HTML inside of the backticks, and injects the data with the string

}

$(document).ready(function() { 

	$('.category').click(function(e) {
		e.preventDefault(); //stop default action of the link
		cat = $(this).attr("href");  //get category from URL

		var request = $.ajax({
			url: "api.php?cat=" + cat,
			method: "GET",
			dataType: "json"});

		request.done(function( data ) {
			console.log(data);

  			//place data.title on page 
  			$("#title").html(data.title); //allows us to toggle between Bond Films by Year and the other one

			//clear previous output
			$("#output").html("");



			//jQuery .each loop method to loop through data.films and place on page
			//create variable for data to be passed into the bondTemplate for each item
			//jQuery to pass this template data into id of films in the HTML 
			$.each(data.data, function(i, item) {
				let myData = albumTemplate(item);
				$("<div></div>").html(myData).appendTo("#output");
			}); 
		
			$("#output").html(myData); //onclick data should show up on HTML page

		});

		request.fail(function(xhr, status, error ) {
			alert('Error - ' + xhr.status + ': ' + xhr.statusText);
		});
	});
}); 


</script>
</head>
	<body>
	<h1>RuPaul's Drag Race Web Service</h1>
		<a href="album" class="category">Top Albums</a><br />
		<a href="season" class="category">RuPaul's Drag Race by Season</a>

		<h3 id="title">Title Will Go Here</h3>
		<div id="output">Results go here</div>
	</body>
</html>

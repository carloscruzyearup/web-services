<html>
	<head>
		<title>Top Music Lists Web Service Demo</title>

		<style>
			body {font-family:sans-serif;}

			.item {
				border-top: 2px dotted gray;
				padding: 30px;
				display: flex;
				flex-flow: row wrap;
				justify-content: flex-start;
				gap: 15px;
				align-items: center;
			}
		
			.pic img { /*ensures thumbnail width is at 50px*/
				max-width: 150px;
			}
		</style>

		<script src="https://code.jquery.com/jquery-latest.js"></script>

		<script type="text/javascript">

		function itemTemplate(item){
		
			let data = `
				<div class="item">
		      <div class="pic"><img src="thumbnails/${item.Image}"/></div>
					<div>
						<b>Rating</b>: ${item.Rating}<br/>
			`;
		
			if(item.Song != null)
				data +=	`<b>Song</b>: ${item.Song}<br/>`;
		
			data += `
						<b>Year</b>: ${item.Year}<br/>
						<b>Album</b>: ${item.Album}<br/>
						<b>Artist</b>: ${item.Artist}<br/>
						<b>Genre</b>: ${item.Genre}<br/>
					</div>
				</div> 
			`; //put HTML inside of the backticks, and injects the data with the string
		
			return data;
		
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
						let myData = itemTemplate(item);
						console.log(myData);
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
		<h1>Top Music Lists Web Service</h1>
		<a href="album" class="category">Top Albums</a><br />
		<a href="song" class="category">Top AC/DC songs</a>

		<h3 id="title">Click one of the links above to view the ranked lists!</h3>
		<div id="output"></div>
	</body>
</html>

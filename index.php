<!DOCTYPE html>
<html>
<head>

<!-- Plugins -->
<script src="plugins/jquery-1.12.0.js" type="text/javascript"></script>

</head>
<style>

.container {
	width: 100%;
}
.tableContainer {
	width: 100%;
}
#redditPhpFeedTable {
	width: 90%;
	border-collapse: collapse;
	border: 1px solid grey;
	margin: 25px auto 45px auto;
}
#redditPhpFeedTable th {
	padding: 5px;
	background-color: salmon;
}
#redditPhpFeedTable td {
	text-align: center;
	padding: 5px;
}

</style>
<body>

<div class="container">
	<div class="tableContainer">
		<table id="redditPhpFeedTable">
			<thead>
				<th style="">Title</th>
				<th style="width:25%;">Author</th>
				<th style="width:10%;">Number of Comments</th>
				<th style="width:10%;">Score</th>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
</div>

</body>
<script>

$(function() {
	ui_rr.init();
});

ui_rr = {
	
	//----------------------------------------------
	// init(): 
	//----------------------------------------------
	init: function() {
		ui_rr.getRedditJsonData();
	},
	
	//----------------------------------------------
	// getRedditJsonData(): 
	//----------------------------------------------
	getRedditJsonData: function() {
		ui_rr.log("getRedditJsonData() - start");
		
		// Make ajax call to get json data from reddit url
		var jqxhr = $.getJSON("https://www.reddit.com/r/PHP/.json", function(jsonData) {
			var jsonStr = JSON.stringify(jsonData);
			
			// Request was a success
			ui_rr.log("getRedditJsonData() - success; data = " + jsonStr);
			
			// Process data
			var postArray = jsonData.data.children;
			var postArrayLength = postArray.length;
			var str = "";
			var oneItem = "";
			
			// Empty table body 
			$("#redditPhpFeedTable tbody").remove();
			
			// Begin building table body
			str += "<tbody>";
			
			for (var i = 0; i < postArrayLength; i++) {
				oneItem = postArray[i];
				
				// Begin table row
				str += "<tr>";
				
				// Begin table row data
				str += "<td><a href=\"" + oneItem.data.url + "\" target=\"_blank\">" + oneItem.data.title + "</a></td>";
				str += "<td>" + oneItem.data.author + "</td>";
				str += "<td>" + oneItem.data.num_comments + "</td>";
				str += "<td>" + oneItem.data.score + "</td>";
				
				str += "</tr>";
			}
			
			str += "</tbody>";
			
			// Populate table data
			$("#redditPhpFeedTable").append(str);
		});
		
		// Request failed
		jqxhr.fail(function() {
			ui_rr.log("getRedditJsonData() - failed");
		});
		
		// Request completed
		jqxhr.complete(function() {
			ui_rr.log("getRedditJsonData() - completed");
		});
	},
	
	//----------------------------------------------
	// log(): console log messages
	//----------------------------------------------
	log: function(message) {
		console.log(message);
	}
}

</script>
</html>

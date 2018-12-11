function getContent(id)
{
	var queryString = {'since_id' : id};

	$.ajax(
		{
			type: 'GET',
			url: 'gistfile1.php',
			data: queryString,
			dataType: 'json',
			success: function(data){
				$('#response').text(JSON.stringify(data, null, 2));
				if($.isEmptyObject(data)) getContent(id);
				else getContent(data[0].id);
			}
		}
	);
}

$(function() {
	getContent();
});

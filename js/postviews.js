jQuery.ajax({
	type:"GET",
	url:postviewvar.rhpost_ajax_url,
	data:"postviews_id="+encodeURIComponent(postviewvar.post_id)+"&action="+encodeURIComponent('rehubpostviews'),
	cache:!1
});
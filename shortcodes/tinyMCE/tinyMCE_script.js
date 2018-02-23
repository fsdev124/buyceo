(function() {

var d = new Date();

var month = d.getMonth()+1;
var day = d.getDate();

var outputdate = d.getFullYear() + '.' +
    (month<10 ? '0' : '') + month + '.' +
    (day<10 ? '0' : '') + day;	

	tinymce.create('tinymce.plugins.Addshortcodes', {
		init : function(ed, url) {

			ed.addButton('contents', {  
				title : 'Auto contents',  
				image : url+'/images/contents.png',  
				onclick : function() {
					//if(ed.selection.getContent().length > 0)				
					ed.selection.setContent('[contents h2]');  
				}  
			}); 

			ed.addButton('sticky', {  
				title : 'Sticky auto contents',  
				image : url+'/images/post_images.png',  
				onclick : function() {
					//if(ed.selection.getContent().length > 0)				
					ed.selection.setContent('[wpsm_stickypanel][contents h2][/wpsm_stickypanel]');  
				}  
			}); 										 
			
			ed.addButton('toplist', {  
				title : 'Top list',  
				image : url+'/images/star.png',  
				onclick : function() {
					//if(ed.selection.getContent().length > 0)				
					ed.selection.setContent('[wpsm_toplist]');  
				}  
			});

			ed.addButton('linkhider', {  
				title : 'Hidden link from google',  
				image : url+'/images/link.png',  
				onclick : function() {
					//if(ed.selection.getContent().length > 0)				
					ed.selection.setContent('[wpsm_hidelink text="" link=""]');  
				}  
			});				

			ed.addButton('update', {  
				title : 'Update notice',  
				image : url+'/images/update.png',  
				onclick : function() {
					//if(ed.selection.getContent().length > 0)				
					ed.selection.setContent('[wpsm_update date="' + outputdate + '" label="Update"][/wpsm_update]');  
				}  
			});	

			ed.addButton('award', {  
				title : 'Cup Icon',  
				image : url+'/images/award.png',  
				onclick : function() {
					//if(ed.selection.getContent().length > 0)				
					ed.selection.setContent('🏆');  
				}  
			}); 					
								  			
		},
	});
	tinymce.PluginManager.add('wpsm_shortcode', tinymce.plugins.Addshortcodes);	
	
})();
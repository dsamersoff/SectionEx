SectionEx.ready(function($)
{
	var sectionex = window.sectionex = {
		more: function( catid, startlimit, totalitems) {
		    sort    = $('#filter_order').val();
		    sejax.load('category', 'more', catid, startlimit, totalitems, sort);
		},
		
		confirmArticleStateChange: function( articleId, authorId, state ) {
		    sejax.load('category', 'confirmArticleStateChange', articleId, authorId, state);
		},
		
		confirmArticleTrash: function( articleId, authorId ) {
		    sejax.load('category', 'confirmArticleStateChange', articleId, authorId, '-2');
		},
		
		updatestatus: function()
		{
		    var articleId	= $('#articleid').val();
		    var authorId	= $('#authorid').val();
		    var returnlink	= $('#return').val();
		    var state		= $('#state').val();
		
		    sejax.load('category', 'updateArticleState', articleId, authorId, state, returnlink);
		},
		
	    updateArticleOpac: function( articleId, state )
	    {
	        if( state == '1' )
	        {
	            $('#article-' + articleId + ' div').removeClass('unpublished');
	        }
	        else if( state == '0' )
	        {
				$('#article-' + articleId + ' div').addClass('unpublished');
	        }
	        else
	        {
	            $('#article-' + articleId).remove();
	        }
	    }
	}
});


jQuery(document).ready(function($){

    $('[data-tttloadmore-do]').on('click',function(event) {
        event.preventDefault();

        $(this).trigger('ttt-loadmore:before-click');
        if ( $(this).data('break') == true ) return false;

        var button = $(this);
        var ndo = $(this).attr('data-tttloadmore-do');
        var to = $(this).attr('data-tttloadmore-to');
        var page = Number( $(this).attr('data-tttloadmore-page') );
        var args = $(this).attr('data-tttloadmore-args');

        if ( page <= 1 || isNaN(page) ) {
            page = 2;
        }
        else {
            page++;
        }

        
        $(this).attr('data-tttloadmore-page', page);

        var data = {
			'action': 'ttt-loadmore',
            'ndo': ndo,
            'page': page,
            'args': args
		};

		$.ajax({
			url: tttloadmoreConf.ajax,
			type: 'get',
			context: $( to ),
			data: data,
			complete: function(data) {

                var el = $( data.responseText );

                $(this).trigger('ttt-loadmore:before-load', [data, el] );
                if ( $(this).data('break') == true ) return false;

                if (el.length <= 0)
                    $(button).fadeOut();
                else
                    $(this).append( el );

                $(this).trigger('ttt-loadmore:after-load', [data, el] );

                
			}
		});
        
        $(this).trigger('ttt-loadmore:after-click');

    });
    
});


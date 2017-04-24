( function( $ ) {

	// Site Title
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newval ) {
			$('header h1#logo').html( newval );
		} );
	} );

	// Header > Title
	wp.customize( 'kichu_title', function( value ) {
		value.bind( function( newval ) {
			$('header h1#logo').css('color', newval );
			$('button#showRightPush').css('color', newval );
		} );
	} );

	// Header > Header Background
	wp.customize( 'kichu_title_background', function( value ) {
		value.bind( function( newval ) {
			$('header').css('background-color', newval );
		} );
	} );

	// Header > Menu Title
	wp.customize( 'kichu_menu_title', function( value ) {
		value.bind( function( newval ) {
			$('.nav-menu h3').css('color', newval );
		} );
	} );

	// Header > Menu Title Background
	wp.customize( 'kichu_menu_title_background', function( value ) {
		value.bind( function( newval ) {
			$('.nav-menu h3').css('background', newval );
			$('.nav-menu-vertical a').css('border-bottom', newval );
		} );
	} );

	// Header > Menu Background
	wp.customize( 'kichu_menu_background', function( value ) {
		value.bind( function( newval ) {
			$('.nav-menu').css('background', newval );
		} );
	} );

	// Header > Menu Links
	wp.customize( 'kichu_menu_links', function( value ) {
		value.bind( function( newval ) {
			$('.nav-menu a').css('color', newval );
			$('.nav-menu a:hover').css('color', newval );
			$('.nav-menu a:active').css('color', newval );
		} );
	} );

	// Header > Menu Links Hover
	wp.customize( 'kichu_menu_links_hover', function( value ) {
		value.bind( function( newval ) {
			$('.nav-menu a').hover(function(){
				$(this).css('background', newval );
			},function(){
				$(this).css('background', 'inherit' );
			}); 
		} );
	} );

	// Primary Section > Background
	wp.customize( 'kichu_primary_background', function( value ) {
		value.bind( function( newval ) {
			$('#main').css('background-color', newval );
		} );
	} );

	// Primary Section > Title
	wp.customize( 'kichu_primary_title', function( value ) {
		value.bind( function( newval ) {
			$('article:nth-child(odd) a.title').css('color', newval );
		} );
	} );

	// Primary Section > Text
	wp.customize( 'kichu_primary_text', function( value ) {
		value.bind( function( newval ) {
			$('article:nth-child(odd)').css('color', newval );
		} );
	} );

	// Primary Section > Link
	wp.customize( 'kichu_primary_link', function( value ) {
		value.bind( function( newval ) {
			$('article:nth-child(odd) .article-meta a').css('color', newval );
			$('article:nth-child(odd) .content a').css('color', newval );
		} );
	} );

	// Primary Section > Link Hover
	wp.customize( 'kichu_primary_link_hover', function( value ) {
		value.bind( function( newval ) {
			$('article:nth-child(odd) .article-meta a').hover(function(){
				$(this).css('color', newval );
			},function(){
				$(this).css('color', 'inherit' );
			}); 
			$('article:nth-child(odd) .content a').hover(function(){
				$(this).css('color', newval );
			},function(){
				$(this).css('color', 'inherit' );
			}); 
		} );
	} );

	// Secondary Section > Background
	wp.customize( 'kichu_secondary_background', function( value ) {
		value.bind( function( newval ) {
			$('body').css('background-color', newval );
			$('article:nth-child(2n)').css('background-color', newval );
			$('.comment-area').css('background-color', newval );
			$('input[type="submit"]').css('background-color', newval );
			$('input[type="submit"]').css('border', newval );
			$('button').css('background-color', newval );
			$('button').css('border', newval );
			$('button#showRightPush').css("background-color", "transparent"); 
		} );
	} );

	// Secondary Section > Title
	wp.customize( 'kichu_secondary_title', function( value ) {
		value.bind( function( newval ) {
			$('article:nth-child(even) a.title').css('color', newval );
			$('.comments-title').css('color', newval );
			$('.comment-navigation .screen-reader-text').css('color', newval );
			$('.comment-navigation .nav-previous a').css('color', newval );
			$('.comment-navigation .nav-next a').css('color', newval );
		} );
	} );

	// Secondary Section > Text
	wp.customize( 'kichu_secondary_text', function( value ) {
		value.bind( function( newval ) {
			$('article:nth-child(even)').css('color', newval );
		} );
	} );

	// Secondary Section > Link
	wp.customize( 'kichu_secondary_link', function( value ) {
		value.bind( function( newval ) {
			$('article:nth-child(even) .article-meta a').css('color', newval );
			$('article:nth-child(even) .content a').css('color', newval );
		} );
	} );

	// Secondary Section > Link Hover
	wp.customize( 'kichu_secondary_link_hover', function( value ) {
		value.bind( function( newval ) {
			$('article:nth-child(even) .article-meta a').hover(function(){
				$(this).css('color', newval );
			},function(){
				$(this).css('color', 'inherit' );
			});
			$('article:nth-child(even) .content a').hover(function(){
				$(this).css('color', newval );
			},function(){
				$(this).css('color', 'inherit' );
			}); 
		} );
	} );

	// Pagination > Background
	wp.customize( 'kichu_pagination_background', function( value ) {
		value.bind( function( newval ) {
			$('.pagination').css('background-color', newval );
		} );
	} );

	// Pagination > Links
	wp.customize( 'kichu_pagination_links', function( value ) {
		value.bind( function( newval ) {
			$('.pagination a').css('color', newval );
			$('.pagination a').hover(function(){
				$(this).css('color', newval );
			});
		} );
	} );

	// Pagination > Links Hover
	wp.customize( 'kichu_pagination_links_hover', function( value ) {
		value.bind( function( newval ) {
			$('.pagination a').hover(function(){
				$(this).css('background-color', newval );
			},function(){
				$(this).css('background-color', 'inherit' );
			}); 
		} );
	} );

	// Footer > Background
	wp.customize( 'kichu_footer_background', function( value ) {
		value.bind( function( newval ) {
			$('.credits').css('background-color', newval );
		} );
	} );

	// Footer > Text/Link
	wp.customize( 'kichu_footer_text', function( value ) {
		value.bind( function( newval ) {
			$('.credits').css('color', newval );
			$('.credits a').css('color', newval );
		} );
	} );

	// Footer > Link Hover
	wp.customize( 'kichu_footer_link_hover', function( value ) {
		value.bind( function( newval ) {
			$('.credits a').hover(function(){
				$(this).css('color', newval );
			},function(){
				$(this).css('color', 'inherit' );
			}); 
		} );
	} );
	
} )( jQuery );

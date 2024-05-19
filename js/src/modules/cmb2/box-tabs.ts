import {ADMIN} from '../../config';


jQuery( function( $ ) {
	'use strict';
	$( '[data-js="lipe/lib/cmb2/box/tabs"]' ).on( 'click', 'a', function( ev: JQuery.ClickEvent ) {
		ev.preventDefault();
		const $li = $( this ).parent(),
			panel = $li.data( 'panel' ),
			$wrapper = $li.parents( '.cmb-tabs' ).find( '.cmb2-wrap-tabs' ),
			$panel = $wrapper.find( '[class*="cmb-tab-panel-' + panel + '"]' );

		try {
			const $redirect = $( '[name="_wp_http_referer"]' ),
				url = new URL( $redirect.val()?.toString() ?? '' );
			url.searchParams.set( ADMIN.cmb2BoxTabs.field, panel );
			$redirect.val( url.toString() );
		} catch ( error ) {
			console.error( error );
		}

		$li.addClass( 'cmb-tab-active' ).siblings().removeClass( 'cmb-tab-active' );
		$wrapper.find( '.cmb-tab-panel' ).removeClass( 'show' );
		$panel.addClass( 'show' );
	} );
} );

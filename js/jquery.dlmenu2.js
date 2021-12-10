/**
 * jquery.dl2menu.js v1.0.1
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */

;( function( $, window, undefined ) {

	'use strict';
 
	// global
	var Modernizr = window.Modernizr;

	$.DL2Menu = function( options, element ) {
		this.$el = $( element );
		this._init( options );
	};

	// the options
	$.DL2Menu.defaults = {
		// classes for the animation effects
		animationClasses : { classin : 'dl2-animate-in-1', classout : 'dl2-animate-out-1' } 
		// callback: click a link that has a sub menu
		// el is the link element (li); name is the level name
 
	};

	$.DL2Menu.prototype = {
		_init : function( options ) {

			// options
			this.options = $.extend( true, {}, $.DL2Menu.defaults, options );
			// cache some elements and initialize some variables
			this._config();
			
			var animEndEventNames = {
					'WebkitAnimation' : 'webkitAnimationEnd',
					'OAnimation' : 'oAnimationEnd',
					'msAnimation' : 'MSAnimationEnd',
					'animation' : 'animationend'
				},
				transEndEventNames = {
					'WebkitTransition' : 'webkitTransitionEnd',
					'MozTransition' : 'transitionend',
					'OTransition' : 'oTransitionEnd',
					'msTransition' : 'MSTransitionEnd',
					'transition' : 'transitionend'
				};
			// animation end event name
			this.animEndEventName = animEndEventNames[ Modernizr.prefixed( 'animation' ) ] + '.dl2menu';
			// transition end event name
			this.transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ] + '.dl2menu',
			// support for css animations and css transitions
			this.supportAnimations = Modernizr.cssanimations,
			this.supportTransitions = Modernizr.csstransitions;

			this._initEvents();

		},
		_config : function() {
			this.open = false;
			this.$trigger = this.$el.children( '.dl2-trigger' );
			this.$menu = this.$el.children( 'ul.dl2-menu' );
//			this.$menuitems = this.$menu.find( 'li:not(.dl2-back)' );
//			this.$el.find( 'ul.dl2-submenu' ).prepend( '' );
//			this.$back = this.$menu.find( 'li.dl2-back' );
		},
		_initEvents : function() {
                    

var self = this;
$('body').on('click', "#clickMe", function() {
				
				if( self.open ) {
     $("#column2").css('left','-1000px');
					self._closeMenu();
 				} 
			});


$("#btnMenu").on( 'click.dl2menu', function() {
			
				if( self.open ) {
                  $("#column2").css('left','-1000px');
				self._closeMenu();
 				} 
				else {
			$("#column2").css('left','10px');
				self._openMenu();
//				});
				}
				return false;

			} );

			this.$menu.on( 'click.dl2menu', function( event ) { self._closeMenu();} );

 

 },
		closeMenu : function() {
			if( this.open ) {
				this._closeMenu();
			}
		},
		_closeMenu : function() {
                     $("#column2").css('left','-1000px');
			var self = this,
				onTransitionEndFn = function() {
					self.$menu.off( self.transEndEventName );
			 
				};
			
			 
			this.$menu.removeClass( 'dl2-menuopen' );
			this.$menu.addClass( 'dl2-menu-toggle' );
			this.$trigger.removeClass( 'dl2-active' );
			
			if( this.supportTransitions ) {
				this.$menu.on( this.transEndEventName, onTransitionEndFn );
			}
			else {
				onTransitionEndFn.call();
			}

			this.open = false;
                        
                        
                     
		},
		openMenu : function() {
			if( !this.open ) {
				this._openMenu();
			}
		},
		_openMenu : function() {
                      
                        $("#columnButton").css("z-index", "10");
			var self = this;
			// clicking somewhere else makes the menu close
			
			this.$menu.addClass( 'dl2-menuopen dl2-menu-toggle' ).on( this.transEndEventName, function() {
				$( this ).removeClass( 'dl2-menu-toggle' );
			} );
			this.$trigger.addClass( 'dl2-active' );
			this.open = true;
		},
		// resets the menu to its original state (first level of options)
		 
	};

	var logError = function( message ) {
		if ( window.console ) {
			window.console.error( message );
		}
	};

	$.fn.dl2menu = function( options ) {
		if ( typeof options === 'string' ) {
			var args = Array.prototype.slice.call( arguments, 1 );
			this.each(function() {
				var instance = $.data( this, 'dl2menu' );
				if ( !instance ) {
					logError( "cannot call methods on dl2menu prior to initialization; " +
					"attempted to call method '" + options + "'" );
					return;
				}
				if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {
					logError( "no such method '" + options + "' for dl2menu instance" );
					return;
				}
				instance[ options ].apply( instance, args );
			});
		} 
		else {
			this.each(function() {	
				var instance = $.data( this, 'dl2menu' );
				if ( instance ) {
					instance._init();
				}
				else {
					instance = $.data( this, 'dl2menu', new $.DL2Menu( options, this ) );
				}
			});
		}
		return this;
	};

} )( jQuery, window );
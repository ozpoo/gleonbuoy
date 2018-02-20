(function ($, root, undefined) {

	$(function () {

		'use strict';

		$(window).load(function() {

			$("body").addClass("show");

			$(document).on("click", ".menu-toggle button", function(){
				$(".menu-modal").toggleClass("show");
			});

			$(document).on("click", ".about-toggle button", function(){
				$(".description").toggleClass("show");
			});

			setTimeout(function(){
				$(".title, .menu-toggle, .next, .previous").addClass("show");
			}, 440);

		});

	});

})(jQuery, this);

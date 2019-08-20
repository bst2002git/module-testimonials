define([
	"jquery",
	'mage/translate'
], function ($) {
	'use strict';

	return function (config, node) {
		var moreLess = {
		    button: {
		        el: $("<a>", {
		            id: "toggle-description",
		            href: "#"+$(node).get(0).id
		        }),
		        expanded_text: $.mage.__('Show less'),
		        collapsed_text: $.mage.__('Show more')
		    },
		    target: {
		        el: $(node),
		        height: $(node).height(),
		        maxHeight: config.contentMaxHeight,
		        collapsedClassName: "collapsed",
				id: $(node).get(0).id,
		    }
		};
		if (moreLess.target.height > moreLess.target.maxHeight) {
		    moreLess.button.el.text(moreLess.button.collapsed_text);

		    moreLess.target.el
		        .addClass(moreLess.target.collapsedClassName)
		        .parent().append(moreLess.button.el);
		}
		moreLess.button.el.on("click", function (e) {
		    if (moreLess.target.el.hasClass(moreLess.target.collapsedClassName)) {
		        moreLess.target.el.removeClass(moreLess.target.collapsedClassName);
		        moreLess.button.el.text(moreLess.button.expanded_text);
		    } else {
		        moreLess.target.el.addClass(moreLess.target.collapsedClassName);
		        moreLess.button.el.text(moreLess.button.collapsed_text);
		    }
		});
	}
});

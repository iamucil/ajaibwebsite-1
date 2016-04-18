angular.module('app.service').factory('ToastyService', function(toasty) {
		var timeout = 10000;
        return {
        	default: function(content,title) {
        		title = (typeof title === 'undefined') ? '' : title;
        		return toasty({
				    title: title,
				    msg: content,
				    showClose: true,
				    clickToClose: true,
				    timeout: timeout,
				    sound: true,
				    html: true,
				    shake: false,
				    theme: "material"
				});
        	},
        	info: function(content,title) {
        		title = (typeof title === 'undefined') ? 'Info' : title;
        		return toasty.info({
				    title: title,
				    msg: content,
				    showClose: true,
				    clickToClose: true,
				    timeout: timeout,
				    sound: true,
				    html: true,
				    shake: false,
				    theme: "material"
				});
        	},
        	success: function(content,title) {
        		title = (typeof title === 'undefined') ? 'Success' : title;
        		return toasty.success({
				    title: title,
				    msg: content,
				    showClose: true,
				    clickToClose: true,
				    timeout: timeout,
				    sound: true,
				    html: true,
				    shake: false,
				    theme: "material"
				});
        	},
        	wait: function(content,title) {
        		title = (typeof title === 'undefined') ? 'Wait' : title;
        		return toasty.wait({
				    title: title,
				    msg: content,
				    showClose: true,
				    clickToClose: true,
				    timeout: timeout,
				    sound: true,
				    html: true,
				    shake: false,
				    theme: "material"
				});
        	},
        	error: function(content,title) {
        		title = (typeof title === 'undefined') ? 'Error' : title;
        		return toasty.error({
				    title: title,
				    msg: content,
				    showClose: true,
				    clickToClose: true,
				    timeout: timeout,
				    sound: true,
				    html: true,
				    shake: false,
				    theme: "material"
				});
        	},
        	warning: function(content,title) {
        		title = (typeof title === 'undefined') ? 'Warning' : title;
        		return toasty.warning({
				    title: title,
				    msg: content,
				    showClose: true,
				    clickToClose: true,
				    timeout: timeout,
				    sound: true,
				    html: true,
				    shake: false,
				    theme: "material"
				});
        	},

        };
    }
);
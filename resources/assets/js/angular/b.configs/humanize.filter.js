angular.module('app.config')
.filter('trim', function() {
    return function(value) {
        if (!angular.isString(value)) {
            return value;
        }
        return value.replace(/^\s+|\s+$/g, ''); // you could use .trim, but it's not going to work in IE<9
    };
}).filter('ucfirst', function() {
    return function(input) {
        if (!input) {
            return null;
        }
        return input.substring(0, 1).toUpperCase() + input.substring(1);
    };
});

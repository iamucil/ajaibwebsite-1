angular.module('app.service').factory('Todo', ['$resource',
    function($resource) {
        return $resource('/api/todo/:todoId', {
            todoId: '@id'
        }, {
            update: {
                method: 'PUT'
            }
        });
    }
]);

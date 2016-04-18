angular.module('app.controller').controller('TodoController', function($scope, $location, $routeParams, Todo) {
    $scope.create = function() {
        var todo = new Todo({
            body: this.body
        });
        todo.$save(function(res) {
            $location.path('todos/view/' + res.id);
            $scope.body = '';
        }, function(err) {
            console.log(err);
        });
    };

    $scope.find = function($container) {
        eval("$scope." + $container + " = Todo.query()");
        console.log('container: ' + container)
        console.log(eval("$scope." + $container))
    };

    $scope.remove = function(todo) {
        todo.$remove(function(res) {
            if (res) {
                for (var i in $scope.todos) {
                    if ($scope.todos[i] === todo) {
                        $scope.todos.splice(i, 1);
                    }
                }
            }
        }, function(err) {
            console.log(err);
        })
    };

    $scope.update = function(todo) {
        todo.$update(function(res) {}, function(err) {
            console.log(err);
        });
    };

    $scope.findOne = function() {
        var splitPath = $location.path().split('/');
        var todoId = splitPath[splitPath.length - 1];
        $scope.todo = Todo.get({ todoId: todoId });
    };
});

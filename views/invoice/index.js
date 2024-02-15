Rest = $injector.get("Rest");

query = function () {
  Rest.query({}, function (r) {
    $scope.items = r;
  });
};

$scope.deleteItem = function (id) {
  Rest.remove({ id: id }, {}, function () {
    query();
  });
};

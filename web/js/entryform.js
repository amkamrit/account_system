	var app=angular.module("App",[]);

	app.controller("entryformcontroller",function($scope,$http)
	{

		$scope.rows = [{"id":"1"},{"id":"1"},{"id":"1"},{"id":"1"},{"id":"1"}];

		$scope.addRow=function()
		{
				var newrow = $scope.rows.length+1;
				$scope.rows.push({"id":"1"});

		};

		$scope.removeRow = function(id) 
		{
	    		$scope.rows.splice(id,1);
	  	};
	

	});


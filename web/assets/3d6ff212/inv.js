
// the todoApp module is not really used, but it is here to show how it can be
// used with the common application scripts ($commonAppScripts)
var invApp = angular.module('invApp', ['ngRoute']);

invApp.factory('getInvItems', function ($http, $q){

    this.getlist = function(i,j){  
        console.log(i);
        return $http({
            method: 'POST',
            url: '/statement/doc-items?docId=' +i+"&invId="+ j,
            // data: note,  //param method from jQuery
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }  //set the headers so angular passing info as form data (not request payload)
        }); 
    }
    return this;
});

invApp.controller('InvCtrl',function ($scope,$http, $window,$timeout,getInvItems) {

    $scope.yiiParams = {};
    setYiiParams($scope.yiiParams);
    //console.log($scope.yiiParams.id);
    $scope.saved = 0;
    $scope.header = {
        invoice_id:null, 
        venue_id:null, 
        customer_id:null, 
        event_date:null
    };
    $scope.id = $scope.yiiParams.id;
    $scope.kf = $scope.yiiParams.kf;
    $scope.header.invoice_id = $scope.yiiParams.kf;
    
   
    $scope.invoice = {    	
        items: [{
            id: null, 
            st_id:null,
            st_type:null,
            quantity: '0', 
            price: '0', 
            description: "", 
            sequence: null,
            status: '0'
        }, {
            id: null, 
            st_id:null,
            st_type:null,
            quantity: '0', 
            price: '0', 
            description: "", 
            sequence: null,
            status: '0'
        }, {
            id: null, 
            st_id:null,
            st_type:null,
            quantity: '0', 
            price: '0', 
            description: "", 
            sequence: null,
            status: '0'
        }, {
            id: null, 
            st_id:null,
            st_type:null,
            quantity: '0', 
            price: '0', 
            description: "",
            sequence: null,
            status: '0'
        }, {
            id: null, 
            st_id:null,
            st_type:null,
            quantity: '0', 
            price: '0', 
            description: "", 
            sequence: null,
            status: '0'
        }]
   // ,selected:{}
    };
    $scope.id = $scope.yiiParams.id;
   
    
    $scope.getTemplate = function (contact) {
        //if (contact.id === $scope.invoice.selected.id) return 'edit';
        //else 
            return 'display';
    };

    $scope.editContact = function (contact) {
        $scope.invoice.selected = angular.copy(contact);
    };
    
    $scope.isSaving = false;
    $scope.load = function($event) {  //alert('saving...');
        $scope.loading = true;
        $scope.isSaving = true;
        $timeout(function() {
            $scope.loading = false; 
        
            console.log('Before save:' );
            console.log($scope.invoice.items);
            $scope.saveItems();
        }, 0);
    }    		
   
  /* getInvItems.getlist($scope.kf,$scope.header.invoice_id).success(function(response)
    {
        $scope.invoice.items = response;
        console.log($scope.invoice.items);
    });*/
    $http.get('/statement/doc-items?docid=' +$scope.kf+"&invid="+ $scope.header.invoice_id)
    .then(function(response)
        {       console.log(response.data);
                $scope.invoice.items = response.data || [];
                console.log($scope.invoice.items);
        })
       $scope.editingData = [];

    for (var i = 0, length = $scope.invoice.items.length; i < length; i++) {
        $scope.editingData[$scope.invoice.items[i].id] = true;
    }
    //$scope.saved = 1;
    $scope.foredit = 1;
          
    $scope.isSaving = undefined;
            
            			
    $scope.invoiceNumber = function (invNum) {
        InvoiceObj.invoiceNumber(invNum);
    }  

    
    $scope.addRow = function () {
        console.log($scope.invoice.items);
        $scope.invoice.items.push({
            id: '0', 
            st_id:$scope.invoice.st_id,
            st_type:$scope.invoice.st_type,
            quantity: '0', 
            price: '0', 
            description: "", 
            sequence: '0',
            status: '0'
        });
        var len = $scope.invoice.items.length;
       $scope.editingData[len] = true;
       // $scope.editingData[2] = true;
         console.log('len:'+$scope.invoice.items);
       
       
    };

    $scope.insertRow = function (row_idx) {
        console.log('Index:' + row_idx);
        var obj = {
            id: null, 
            st_id:null,
            st_type:null,
            quantity: '0', 
            price: '0', 
            description: "", 
            sequence: row_idx,
            status: '0'
        };
       
       $scope.invoice.items.splice(row_idx, 0, obj);
       angular.forEach($scope.invoice.items, function (item, index) {
            //sum += item.quantity * item.price;
             if(index == row_idx)
             $scope.editingData[index + 1] = true;
             else
                 $scope.editingData[index + 1] = false;
            item.sequence = item.id;
       });
       
        console.log('Items afte Insert:' );
        console.log($scope.editingData);
    };

    $scope.deleteRow = function (index) {
        var item = $scope.invoice.items[index];
        if (item.status == 1) item.status = 3;
        else if (item.status == 3) item.status = 1;
        else  
            $scope.invoice.items.splice(index, 1);
        $scope.subTotal();
        $scope.invForm.$setDirty();
    };
    
    $scope.rowTotal = function (row) {
        return accounting.formatMoney(row.quantity * row.price, "$", 2, ",", ".");
    };

    $scope.subTotal = function () {
        var sum = 0;

        angular.forEach($scope.invoice.items, function (item) {
            sum += item.quantity * item.price;
        });
        return accounting.formatMoney(sum, "$", 2, ",", ".");
    };
    
    $scope.calculate_tax = function () {
        return (($scope.taxVal * $scope.subTotal()) / 100);
    }
    $scope.total = function () {
        // localStorage["invoice"] = JSON.stringify($scope.invoice);
        return accounting.formatMoney($scope.calculate_tax() + $scope.subTotal(), "$", 2, ",", ".");
            
    }
        
    $scope.saveItems = function(){
       
        console.log($scope.invoice.items);
        var note = $scope.invoice.items;      
        alert(JSON.stringify(note)); 
        $http({
            method: 'POST',
            url: '/statement/doc-items?docid=' + $scope.kf+"&invid="+$scope.header.invoice_id+"&custid="+$scope.header.customer_id+
            "&venid="+$scope.header.venue_id+"&evdate="+$scope.header.event_date,
            data: note,  //param method from jQuery
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }  //set the headers so angular passing info as form data (not request payload)
        }).success(function (response) {
            console.log(response);
            if(response.length) $scope.invoice.items = response;
           // $window.location.href = '/document/update/pk/'+$scope.id+".html";
           $window.location.reload();
        
        }).error(function (response) { console.log("ERR")});
        $scope.saved = 1;
        $scope.foredit = 1;
           
    }   
        
    $scope.printDiv = function(divName) {
        var printContents = document.getElementByid(divName).innerHTML;
        var originalContents = document.body.innerHTML;        
        var popupWin = window.open('', '_blank', 'width=300,height=300');
        popupWin.document.open()
        popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="style.css" /></head><body onload="window.print()">' + printContents + '</html>');
        popupWin.document.close();
    }    


    /*****************************************/
   

$scope.modify = function(idx){
    //$scope.editingData[tableData.sequence] = true;
    
    
    angular.forEach( $scope.invoice.items, function (item,index) {
            //sum += item.quantity * item.price;
             if(index + 1 == idx)
             $scope.editingData[index + 1] = true;
             else
                 $scope.editingData[index + 1] = false;
           
       });
       console.log("After Edit:");
       console.log($scope.edingData);
};


$scope.update = function(tableData){
    $scope.editingData[tableData.sequence] = false;
};
    /****************************************/
   

});
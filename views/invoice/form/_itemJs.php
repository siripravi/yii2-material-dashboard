<?php
use app\models\InvoiceItems;

use yii\helpers\Html;

?>

<script type="text/javascript">
  // initializiation of counters for new elements
  var lastItem = 0;
  var itemCount = <?php echo $model->itemCount ?>;
  var allTotal = <?php echo $allTotal; ?>
  // the subviews rendered with placeholders
  var trItem = new String(<?php echo yii\helpers\Json::encode($this->render('itemRow', array('id' => $model->itemCount, 'item' => new InvoiceItems(), 'form' => $form), true)); ?>);


  function addItem(button) {
    itemCount++; lastItem++;//alert(itemCount);
    var key = "InvoiceItems_n";
    button.parents('table').children('tbody').prepend(trItem.replace(/idRep/g, 'n' + itemCount));
    var qName = "invoiceitems-" + (itemCount - 1) + "-quantity";
    var pName = "invoiceitems-" + (itemCount - 1) + "-price";
    var curQtyElem = document.getElementById(qName);
    //alert(curQtyElem.value);
    var curPriceElem = document.getElementById(pName);
    var curRowElem = document.getElementById("InvoiceItems_n" + (itemCount - 1) + "_curRow");

    curRowElem.innerHTML = itemCount;
    var curQty = parseFloat(curQtyElem.innerHTML);
    var curPrice = parseFloat(curPriceElem.innerHTML);

    curPriceElem.onkeyup = function () { rowTotal(itemCount, key); }; //alert( lastItem);
    curQtyElem.onkeyup = function () { rowTotal(itemCount, key); };

    curQtyElem.onchange = function () { rowTotal(curRowElem.innerHTML, key); }; //alert( lastItem);
    curPriceElem.onchange = function () { rowTotal(curRowElem.innerHTML, key); };

    document.getElementById("total").innerHTML = 'click save to view total';

  }


  function rowTotal(idx, key) {
    if (key == '') key = 0;
    //alert(key+idx);
    var price = parseFloat(document.getElementById("invoiceitems-" + idx + "-price").value) *
      parseFloat(document.getElementById("invoiceitems-" + idx + "-quantity").value);

    document.getElementById("total").innerHTML = 'click save to view total';
    document.getElementById(key + idx + "_rowTotal").innerHTML = isNaN(price) ? "0.00" : price.toFixed(2);
    /*for (var i=1;i<=itemCount;i++) {
    var price2 = parseFloat(document.getElementById(key+i+"_rowTotal").innerHTML);
    //alert('max:'+lastItem);
    
   }*/
    // grandTotalComp(itemCount - lastItem,lastItem);
  }

  function grandTotalComp(old, now) {
    var key = ""; var gTot = 0;
    //alert(old+""+now);
    //prev items total
    key = "InvoiceItems_";
    if (key == '') key = 0;
    for (var i = 0; i < old; i++) {
      var price = parseFloat(document.getElementById(key + i + "_rowTotal").innerHTML);
      gTot += price;

    }

    //alert('old:'+gTot);
    //new items total

    key = "InvoiceItems_n";
    if (key == '') key = 0;
    for (var i = old + 1; i <= old + now; i++) {
      var price = parseFloat(document.getElementById(key + i + "_rowTotal").innerHTML);
      gTot += price;
      //alert('max:'+lastItem);
    }
    // alert('new:'+gTot);

    document.getElementById("total").innerHTML = isNaN(gTot) ? "0.00" : gTot.toFixed(2);
  }

  window.onload = function () {

    var key = "InvoiceItems_";
    for (var i = 0; i < itemCount; i++) {

      /*var curQtyElem = document.getElementById("InvoiceItems_"+i+"_QUANTITY");
      var curPriceElem = document.getElementById("InvoiceItems_"+i+"_PRICE");
      var curRowElem = document.getElementById("InvoiceItems_"+i+"_curRow");
      */
      //curRowElem.innerHTML = i+1;
      /*var curQty = parseFloat(curQtyElem.value);
      var curPrice = parseFloat(curPriceElem.value);
      
      curPriceElem.onkeyup=function() {rowTotal(curRowElem.innerHTML - 1,key);}; //alert( i);
      curQtyElem.onkeyup=function() {rowTotal(curRowElem.innerHTML - 1,key);}; 
       
       curQtyElem.onchange=function() {rowTotal(curRowElem.innerHTML - 1,key);}; //alert( curQtyElem.value+i);
       curPriceElem.onchange=function() {rowTotal(curRowElem.innerHTML - 1,key);}; 	*/
      // document.getElementById("InvoiceItems_"+i+"_rowTotal").value= isNaN(price)?"0.00":price.toFixed(2);		  
      //document.getElementsByName("InvoiceItems_n"+i+"_PRICE".onchange=function() {rowTotal(i)};
      //document.getElementsByName("InvoiceItems_n"+i+"_PRICE".onchange=function() {rowTotal(i)};
    }
    //document.getElementById("total").value=isNaN(grandTotal)?"0.00":grandTotal.toFixed(2);

  }
</script>
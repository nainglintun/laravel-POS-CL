$(document).ready(function(){

    //when minus btn click
    $('.btn-minus').click(function(){
        $parentNode=$(this).parents("tr");
        // find tr and find the pizzaPrice id.
        $price=Number($parentNode.find('#price').text().replace("Ks",""));
        $qty=Number($parentNode.find('#qty').val());
    //    $result=$price*$qty;  
        // console.log($price);
        // console.log($qty);
        // console.log($result);
        $total=$price * $qty;
        $parentNode.find('#total').html($total+" Ks"); 
        summaryCalculation();
        
        
    })
    // event parameter mean current thing and event.target mean things into current.
    //this.parent
    //event.target or this 
    // when plus btn click
    $('.btn-plus').click(function(){
        // console.log(($(event.target)));
        // assign parent and find the tr tag.
        $parentNode=$(this).parents("tr");
        // find tr and find the pizzaPrice id.
        $price=Number($parentNode.find('#price').text().replace("Ks",""));
        // console.log($price);
       $qty=Number($parentNode.find('#qty').val());
    //    $result=$price*$qty;  
        // console.log($price);
        // console.log($qty);
        // console.log($result);
        $total=$price * $qty;
        $parentNode.find('#total').html($total+" Ks");        
        // looping table->tr
        //function(index,row)
        // index represent as array number
    summaryCalculation();
    })

    // for remove button 
    $('.btnRemove').click(function(){
        $parentNode=$(this).parents("tr");
        $productId=$parentNode.find(".productId").val();
        // console.log($productId);
        $parentNode.remove();
        // call function for same code
       summaryCalculation();
        
    })
})


// function for same code
function summaryCalculation(){
    $totalPrice=0;
        //row prepresent as one line of data.
        $('#datatable tbody tr').each(function(index,row){
            $totalPrice +=  Number($(row).find('#total').text().replace("Ks",""));
        });
        // console.log($totalPrice);
        $('#subTotalPrice').html(`${$totalPrice} Ks`);
        //total price
        $('#finalPrice').html($totalPrice + 3000 +" Ks");

}
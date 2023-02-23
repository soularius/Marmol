jQuery( window ).load(function(e) {
    var listProducts = document.querySelectorAll('.product_json input');

    for(var i=0; i<listProducts.length; i++){
        listProducts[i].value = JSON.stringify(localStorage.getItem(listProducts[i].id));
    }
    if(document.getElementById('place_order'))
        document.getElementById('place_order').click();

    if(document.getElementsByClassName('woocommerce-order-received').length){
        var dataProduct = Object.entries(localStorage);
        for(var i=0; i<dataProduct.length; i++){
            if(dataProduct[i][0].indexOf("p-") >= 0){
                localStorage.removeItem(dataProduct[i][0]);
            }
        }
    }

});
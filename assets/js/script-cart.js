jQuery( window ).load(function(e) {
    allMethod(); 

    jQuery("[name='update_cart']").prop( "disabled", false );
    jQuery("[name='update_cart']").trigger('click');
    jQuery("[name='update_cart']").prop( "disabled", true );

    jQuery(document).ajaxStop(function() {
        allMethod();
    });

});

function allMethod(){
    var tabProduct = document.getElementsByClassName('product-tab');
    for(var i=0; i<tabProduct.length; i++){
        var callLocalS = tabProduct[i].id;

        var cant = tabProduct[i].getElementsByClassName("cant-art");
        
        var cantStore = parseInt(tabProduct[i].getElementsByClassName('cntStore')[0].value);
        var cantSize = parseInt(tabProduct[i].getElementsByClassName('cntTalla')[0].value);
        var valRow = 0;
        var contRow = 0;
        var contCol = 0;
        var arrayRow = [];
        var arrayCol = new Array();
        var new_value = 0;
        var cont = 0;
        var acumRow = 0;

        
        var valueTotal = 0;
        if(localStorage.getItem(callLocalS)){
            var dat = JSON.parse(localStorage.getItem(callLocalS));
            
            for(var j=0; j<dat.talla.length; j++){
                var id_input = dat.talla[j].store+'-'+dat.talla[j].talla+'-'+dat.product;
                
                document.getElementById(id_input).value = parseInt(dat.talla[j].cant);
                valueTotal += parseInt(dat.talla[j].cant);
            }
            for(var j=0; j<dat.color.length; j++){
                var id_input = 'color-'+dat.color[j].color+'-'+dat.product;
                
                document.getElementById(id_input).checked = true;
            }
            //jQuery('#'+callLocalS).append(''+jQuery(dat));

            var tr = document.getElementById('product-'+dat.product);
            tr.getElementsByClassName('qty')[0].value = valueTotal;
        }
        
        for(var j = 0; j < cantSize; j++){
            arrayCol[j] = 0;
        }

        cont = 0;
        acumRow = 0;
        contCol = 0;

        for(var j = 0; j <= (cant.length); j++){

            if((cont%cantSize)==0 && j!=0){
                var tab = tabProduct[i].getElementsByClassName('total-'+contRow)[0].innerText = acumRow;
                arrayRow.push(acumRow);
                acumRow = 0;
                contCol = 0;
                contRow += 1;
            }
            
            if(j<(cant.length)){
                new_value = parseInt(cant[j].value) + new_value;
                valRow += parseInt(cant[j].value);
                arrayCol[contCol] += parseInt(cant[j].value);
            }
            if(j==(cant.length))
                break;

            acumRow += parseInt(cant[j].value);
            cont++;
            contCol++;
        }

        for(var j = 0; j < cantSize; j++){
            tabProduct[i].getElementsByClassName('total-size-'+j)[0].innerText = arrayCol[j];
        }        
        if(new_value > 0){
            tabProduct[i].getElementsByClassName("global-total")[0].innerText = new_value;
        }
        else{
            tabProduct[i].getElementsByClassName("global-total")[0].innerText = 0;
        }
    }

    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            var tab = document.getElementsByClassName("product-tab");

            var tabChange = this.firstElementChild.dataset.idtab;
            var pes = document.getElementById(tabChange);

            for (i = 0; i < tab.length; i++) {
                if(tab[i] != pes)
                    tab[i].style.display = 'none';
            }
            var coll_r = document.getElementsByClassName("collapsible");
            for (i = 0; i < coll_r.length; i++) {
                if(coll_r[i] != this)
                    coll_r[i].classList.remove('active');
            }
            this.classList.toggle("active");
            jQuery( '#'+tabChange ).toggle('slow');
        });
    }

    var save = document.getElementsByClassName("save-detail");

    for (i = 0; i < save.length; i++) {
        save[i].addEventListener("click", function() {
            var idBoxInput = 'p-'+this.dataset.id;
            var boxInput = document.getElementById(idBoxInput);
            var inputElemntCant = boxInput.getElementsByClassName('cant-art');
            var cantArt = boxInput.getElementsByClassName('cant-art');

            
            var inputElemntColor = boxInput.getElementsByClassName('color-data');
            var color_var = boxInput.getElementsByClassName('color-data');

            var dat = new Object;
            var id_product = document.getElementById('product-id-'+this.dataset.id).value;

            dat.product = id_product;

            var color = new Array;
            var dat_color = new Object;

            var talla = new Array;
            var dat_talla = new Object;

            var valueTotal = 0;

            for(var i=0; i<cantArt.length; i++){
                if(cantArt[i].value > 0){
                    dat_talla = new Object;
                    dat_talla.store =  cantArt[i].dataset.tienda;
                    dat_talla.talla = cantArt[i].dataset.talla;
                    dat_talla.cant = cantArt[i].value;
                    valueTotal += parseInt(cantArt[i].value);
                    talla.push(dat_talla);
                }
            }            

            dat.talla = talla;

            for(var i=0; i<color_var.length; i++){
                if(color_var[i].checked){
                    dat_color = new Object;
                    dat_color.color =  color_var[i].dataset.id;
                    color.push(dat_color);
                }
            }            

            dat.color = color;

            localStorage.setItem('p-'+id_product, JSON.stringify(dat));

            var tr = document.getElementById('product-'+this.dataset.id);
            tr.getElementsByClassName('qty')[0].value = valueTotal;

            jQuery("[name='update_cart']").trigger('click');

            jQuery("[name='update_cart']").prop( "disabled", true );
        });
    }

    jQuery(".cant-art").bind('keyup mouseup', function () {
        if(this.value == ''){
            this.value = 0;
        }

        var tabProduct = document.getElementsByClassName('product-tab');
        for(var i=0; i<tabProduct.length; i++){
            var new_value = 0;
            var cant = tabProduct[i].getElementsByClassName("cant-art");
    
            var cantStore = parseInt(tabProduct[i].getElementsByClassName('cntStore')[0].value);
            var cantSize = parseInt(tabProduct[i].getElementsByClassName('cntTalla')[0].value);
            var valRow = 0;
            var contRow = 0;
            var contCol = 0;
            var arrayRow = [];
            var arrayCol = new Array();

            for(var j = 0; j < cantSize; j++){
                arrayCol[j] = 0;
            }
            
            cont = 0;
            acumRow = 0;
            contCol = 0;

            for(var j = 0; j <= (cant.length); j++){

                if((cont%cantSize)==0 && j!=0){
                    var tab = tabProduct[i].getElementsByClassName('total-'+contRow)[0].innerText = acumRow;
                    arrayRow.push(acumRow);
                    acumRow = 0;
                    contCol = 0;
                    contRow += 1;
                }
                
                if(j<(cant.length)){
                    new_value = parseInt(cant[j].value) + new_value;
                    valRow += parseInt(cant[j].value);
                    arrayCol[contCol] += parseInt(cant[j].value);
                }
                if(j==(cant.length))
                    break;

                acumRow += parseInt(cant[j].value);
                cont++;
                contCol++;
            }
            
            for(var j = 0; j < cantSize; j++){
                tabProduct[i].getElementsByClassName('total-size-'+j)[0].innerText = arrayCol[j];
            }
    
            if(new_value > 0){
                var price_sub_base = tabProduct[i].getElementsByClassName('bas-sub-price')[0].value;
                var price_base = tabProduct[i].getElementsByClassName('bas-price')[0].value;

                var main = document.getElementById('product-'+tabProduct[i].dataset.id);  

                var boxPrice = main.getElementsByClassName('woocommerce-Price-amount')[1];
                boxPrice.firstElementChild.lastChild.textContent = (parseInt(price_base)*new_value);

                boxPrice = main.getElementsByClassName('woocommerce-Price-amount')[0];
                boxPrice.firstElementChild.lastChild.textContent = (parseInt(price_sub_base)*new_value);
                tabProduct[i].getElementsByClassName("global-total")[0].innerText = new_value;
            }
            else{
                var price_sub_base = tabProduct[i].getElementsByClassName('bas-sub-price')[0].value;
                var price_base = tabProduct[i].getElementsByClassName('bas-price')[0].value;

                var main = document.getElementById('product-'+tabProduct[i].dataset.id);

                var boxPrice = tabProduct[i].getElementsByClassName('woocommerce-Price-amount')[1];
                boxPrice.firstElementChild.lastChild.textContent = (parseInt(price_base));

                boxPrice = main.getElementsByClassName('woocommerce-Price-amount')[0];
                boxPrice.firstElementChild.lastChild.textContent = (parseInt(price_sub_base));    
                tabProduct[i].getElementsByClassName("global-total")[0].innerText = 0;
            }

        }
        
        var btn = updateDat = document.querySelector(".shop_table .actions button[name='update_cart']");
        btn.disabled = false;
    });
}
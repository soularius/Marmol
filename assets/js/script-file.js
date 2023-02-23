jQuery(function() {

    if(!document.getElementsByClassName('woocommerce-product-details__short-description').length)
        return;

    jQuery("input[name=quantity]").val(0);
    //jQuery("input[name=quantity]").css("display", "none");

    if (window.localStorage.getItem('ref') !== undefined
      && window.localStorage.getItem('ref')
    ){
        var bodyD = document.getElementById('page-struct');
        var getLastProduct = JSON.parse(localStorage.getItem('ref'));

        //if(!bodyD.classList.contains('postid-'+getLastProduct.id)){
            document.getElementById('duplicate-qty').classList.remove('d-none');
            document.getElementById('duplicate-qty').classList.add('d-flex');
            var dQTY = document.getElementById('duplicate-qty-btn');
            dQTY.addEventListener("click", () => {
                var getLastProduct = JSON.parse(localStorage.getItem('ref'));
                var idP = JSON.parse(localStorage.getItem(getLastProduct.idP));

                var color = document.getElementsByClassName('color-data');
                for(var i=0; i<color.length; i++){
                    if(idP.color.some(product => product.color === color[i].dataset.id))
                        color[i].checked = true;
                    else
                        color[i].checked = false;
                }

                var qtyProduct = document.getElementsByClassName('cant-art');
                for(var i=0; i<qtyProduct.length; i++){
                    if(idP.talla.some(product => product.store === qtyProduct[i].dataset.tienda) && idP.talla.some(product => product.talla === qtyProduct[i].dataset.talla))
                    {
                        var found = idP.talla.find(element => (element.store === qtyProduct[i].dataset.tienda && element.talla === qtyProduct[i].dataset.talla));
                        if(found){
                            console.log(found);
                            console.log(qtyProduct[i]);
                            qtyProduct[i].value = found.cant;
                        }
                        else{
                            qtyProduct[i].value = 0;
                        }
                    }
                    else{
                        qtyProduct[i].value = 0;
                    }
                }
                var store = document.getElementsByClassName('check-data');
                for(var i=0; i<store.length; i++){
                    var found = idP.talla.find(element => (element.store === store[i].dataset.id));
                    if(!found){
                        store[i].checked = true;
                    }
                }
                calculateCant();
                for(var i=0; i<store.length; i++){
                    store[i].checked = false;
                }
                for(var i=(qtyProduct.length/(store.length+1)); i<qtyProduct.length; i++){
                    qtyProduct[i].disabled = true;
                }
            });
        //}
    }

    checkbox = document.getElementsByClassName('check-data');
    
    for(var i=0; i<checkbox.length; i++){
        checkbox[i].addEventListener('change', (event) => {
            var datCheck = event.currentTarget;
            var idDataCheck = datCheck.dataset.id;
            if (datCheck.checked) {
                inputChecked(idDataCheck, false);
            } 
            else {
                inputChecked(idDataCheck, true);
                
                var cantSize = parseInt(document.getElementById('cntTalla').value);
                var numbInput = document.querySelectorAll('.original input[type="number"]');
        
                for(var i = 0; i < (cantSize+1); i++){
                    var numbInputCopy = document.querySelectorAll('.copy input[type="number"][data-col="'+i+'"]');
                    for(var j = 0; j < numbInputCopy.length; j++){
                        var checkInput = document.getElementById("check-"+(j+1));
                        if(!checkInput.checked)
                            numbInputCopy[j].value = numbInput[i].value;
                    }                    
                }
            }
            calculateCant();
        });
    }

    function inputChecked(id, disable)
    {
        var inputNumb = document.querySelectorAll('.cant-art[data-row="'+id+'"]');
        
        for(var i=0; i<inputNumb.length; i++){
            inputNumb[i].disabled = disable;
        }
    }


    jQuery(".cant-art").bind('keyup mouseup', function () {
        if(this.value == ''){
            this.value = 0;
        }
        calculateCant();
    });

    function calculateCant()
    {
        
        var new_value = 0;
        var cant = document.getElementsByClassName("cant-art");
        var cantStore = parseInt(document.getElementById('cntStore').value);
        var cantSize = parseInt(document.getElementById('cntTalla').value);
        var valRow = 0;
        var contRow = 0;
        var contCol = 0;
        var arrayRow = [];
        var arrayCol = [];
        var acumRow = 0;

        for(var i = 0; i < cantSize; i++){
            arrayCol[i] = 0;
        }
                
        var numbInput = document.querySelectorAll('.original input[type="number"]');        
        for(var i = 0; i < (cantSize+1); i++){
            var numbInputCopy = document.querySelectorAll('.copy input[type="number"][data-col="'+i+'"]');
            for(var j = 0; j < numbInputCopy.length; j++){
                var checkInput = document.getElementById("check-"+(j+1));
                if(!checkInput.checked)
                    numbInputCopy[j].value = numbInput[i].value;
            }
            
        }

        cont = 0;
        acumRow = 0;
        contCol = 0;
        for(var i = 0; i <= (cant.length); i++){
            if((cont%cantSize)==0 && i!=0){
                arrayRow.push(acumRow);
                acumRow = 0;
                contCol = 0;
            }
            if(i<(cant.length)){
                new_value = parseInt(cant[i].value) + new_value;
                valRow += parseInt(cant[i].value);
                arrayCol[contCol] += parseInt(cant[i].value);
            }
            if(i==(cant.length))
                break;
            acumRow += parseInt(cant[i].value);
            cont++;
            contCol++;
        }
        
        for(var i = 0; i < arrayRow.length; i++){
            document.getElementById('total-'+i).innerText = arrayRow[i];
        }


        for(var i = 0; i < arrayCol.length; i++){
            document.getElementById('total-size-'+i).innerText = arrayCol[i];
        }

        var inp = document.getElementsByName('quantity');
        inp[0].value = parseInt(new_value);

        if(new_value > 0){
            var price_sub_base = document.getElementById('bas-sub-price').value;
            var price_base = document.getElementById('bas-price').value;
            var main = document.getElementById('main');
            var boxPrice = main.getElementsByClassName('woocommerce-Price-amount')[0];
            boxPrice.firstElementChild.lastChild.textContent = (parseInt(price_base)*new_value);
            document.getElementById("global-total").innerText = new_value;
        }
        else{
            var price_sub_base = document.getElementById('bas-sub-price').value;
            var price_base = document.getElementById('bas-price').value;
            var main = document.getElementById('main');
            var boxPrice = main.getElementsByClassName('woocommerce-Price-amount')[0];
            boxPrice.firstElementChild.lastChild.textContent = (parseInt(price_base));                
            document.getElementById("global-total").innerText = 0;
        }
    }
    
    var btnAddCart = document.getElementsByName('add-to-cart');
    btnAddCart[0].addEventListener("click", () => {
        var cantArt = document.getElementsByClassName('cant-art');
        var dat = new Object;
        var id_product = document.getElementById('product-id-rt').value;
        dat.product = id_product;

        var color = new Array;
        var dat_color = new Object;

        var talla = new Array;
        var dat_talla = new Object;

        for(var i=0; i<cantArt.length; i++){
            if(cantArt[i].value > 0){
                dat_talla = new Object;
                dat_talla.store =  cantArt[i].dataset.tienda;
                dat_talla.talla = cantArt[i].dataset.talla;
                dat_talla.cant = cantArt[i].value;
                talla.push(dat_talla);
            }
        }
        

        dat.talla = talla;

        var color_var = document.getElementsByClassName('color-data');

        for(var i=0; i<color_var.length; i++){
            if(color_var[i].checked){
                dat_color = new Object;
                dat_color.color =  color_var[i].dataset.id;
                color.push(dat_color);
            }
        }
        

        dat.color = color;

        localStorage.setItem('p-'+id_product, JSON.stringify(dat));

        var ref = new Object;
        var d = new Date();

        ref.id = id_product;
        ref.idP = 'p-'+id_product;
        ref.date = d.getTime();

        localStorage.setItem('ref', JSON.stringify(ref));
    });
    

});
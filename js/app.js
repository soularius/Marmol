jQuery( document ).ready(function() {
    /*const sidebarBox = document.querySelector('#nav-list'),
    sidebarBtn = document.querySelector('#btn-burguer'),
    pageWrapper = document.querySelector('#page-struct');

    sidebarBtn.addEventListener('click', event => {
        sidebarBtn.classList.toggle('active');
        sidebarBox.classList.toggle('active');
    });

    pageWrapper.addEventListener('click', event => {

        if (sidebarBox.classList.contains('active')) {
                sidebarBtn.classList.remove('active');
                sidebarBox.classList.remove('active');
        }
    });

    window.addEventListener('keydown', event => {

        if (sidebarBox.classList.contains('active') && event.keyCode === 27) {
                sidebarBtn.classList.remove('active');
                sidebarBox.classList.remove('active');
        }
    });*/

    var userL = document.getElementsByClassName('user-login');
    if(userL.length)
    {
        var uy = document.querySelector('#account-marmol .woocommerce-MyAccount-content>p>a');
        if(uy != undefined)
            uy.addEventListener('click', function (e) {
                e.preventDefault();
                for(var i =0; i < localStorage.length; i++){
                    var key = localStorage.key(i);
                    if(key.includes('p-'))
                    {
                        /* console.log(localStorage.key(i)); */
                        /* console.log(localStorage.getItem(localStorage.key(i))); */
                        localStorage.removeItem(key);
                    }
                }
                localStorage.removeItem('ref');
                window.location = this.href;
            });
    }


    jQuery( "#site-header-cart" ).hover(
        function() {
          jQuery( '#site-header-cart .dropdown-cart-mar' ).show();
        }, function() {
          jQuery( '#site-header-cart .dropdown-cart-mar' ).hide();
        }
    );
});
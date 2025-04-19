<?php 

/*
	Nome: Arquivo que contem scripts de Javascript da Pagina Web
	Copyright: 2022-2023 © Herman&Joel
	Descrição: Scripts Javascript...

*/

?>

    <script src="/Projecto-Final/public/js/bootstrap-5.0.2/bootstrap.min.js"></script>

    <Script>

            function Alert(type,msg,position='body'){
                let bg_class = (type == "success") ? "alert-success" : "alert-danger";
                let elemento = document.createElement('div');

                    elemento.innerHTML = `<div class="alert ${bg_class} alert-dismissible fade show" role="alert">
                        <strong class="me-3">${msg}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                        
                    if(position=='body'){
                        document.body.append(elemento);
                        elemento.classList.add('custom-alert');
                    }else{
                        document.getElementById(position).appendChild(elemento);
                    }

                setTimeout(function() {
                    elemento.remove();
                }, 2000);
            }
                    
    </Script>
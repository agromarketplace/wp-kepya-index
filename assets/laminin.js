document.addEventListener('DOMContentLoaded', ()=> {
    producto();
    colaborador();
    mercado();
    history();
});
const producto = () => {
    let produtoForm = document.querySelector("#produtoForm");

    document.addEventListener("submit", (e) => {
        e.preventDefault();

        let data = {
            product_name: produtoForm.querySelector('[name="product_name"]').value
        }

        if(!data.product_name){
            return false;
        }


        let url = produtoForm.dataset.url;
        let params = new URLSearchParams(new FormData(produtoForm));

        fetch(url, {
            method: "POST",
            body: params,
        }).then(res => res.json())
            .catch(error => {
                console.log('error');
            }).then(response => {
            console.log('success');
            spinner();
        });

    });
}
const mercado = () => {
    let mercadoForm = document.querySelector("#mercadoForm");

    document.addEventListener("submit", (e) => {
        e.preventDefault();

        let data = {
            mercado_name: mercadoForm.querySelector('[name="mercado_name"]').value
        }

        if(!data.mercado_name){
            return false;
        }


        let url = mercadoForm.dataset.url;
        let params = new URLSearchParams(new FormData(mercadoForm));

        fetch(url, {
            method: "POST",
            body: params,
        }).then(res => res.json())
            .catch(error => {
                console.log('error');
            }).then(response => {
            console.log('success');
            spinner();
        });

    });
}

const colaborador = () => {
    let colaboradorForm = document.querySelector("#colaboradorForm");

    document.addEventListener("submit", (e) => {
        e.preventDefault();

        let data = {
            colaborador_name: colaboradorForm.querySelector('[name="colaborador_name"]').value
        }


        if(!data.colaborador_name) {
            return false;
        }
        let url = colaboradorForm.dataset.url;
        let params = new URLSearchParams(new FormData(colaboradorForm));

        fetch(url, {
            method: "POST",
            body: params,
        }).then(res => res.json())
            .catch(error => {
                console.log('error');
            }).then(response => {
            console.log('success');
            spinner();
        });

    });

}


const history = () => {
    let historyForm = document.querySelector("#historyForm");

    document.addEventListener("submit", (e) => {
        e.preventDefault();


        let data = {
            mercado_id: historyForm.querySelector('[name="mercado_id"]').value,
            product_id: historyForm.querySelector('[name="product_id"]').value,
            colaborador_id: historyForm.querySelector('[name="colaborador_id"]').value,
            product_price: historyForm.querySelector('[name="product_price"]').value,
            product_date_start: historyForm.querySelector('[name="product_date_start"]').value,
            product_date_end: historyForm.querySelector('[name="product_date_end"]').value

        }

        let url = historyForm.dataset.url;
        let params = new URLSearchParams(new FormData(historyForm));

        fetch(url, {
            method: "POST",
            body: params,
        }).then(res => res.json())
            .catch(error => {
                console.log('error');
            }).then(response => {
            console.log('success');
            spinner();

        });

    });
}


function spinner(){
    document.querySelector(".spiner").classList.add("is-active");
    setTimeout(function(){
        window.location.reload();
    }, 2000);
}
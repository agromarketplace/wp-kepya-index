document.addEventListener('DOMContentLoaded', ()=> {
    kepia();
});
const kepia = () => {
    let keypaForm = document.querySelector("#keypaForm");

    document.addEventListener("submit", (e) => {
        e.preventDefault();

        let data = {
            datasearch: keypaForm.querySelector('[name="datasearch"]').value,
            mercado_name: keypaForm.querySelector('[name="mercado_name"]').value
        }

        if(!data.datasearch || !data.mercado_name ){
            return false;
        }


        let url = keypaForm.dataset.url;
        let params = new URLSearchParams(new FormData(keypaForm));

        fetch(url, {
            method: "POST",
            body: params,
        }).then(res => res.json())
            .catch(error => {
                console.log('error');
            }).then(response => {

            setTimeout(function(){
                window.location.reload();
            },1000);
        });

    });
}

function spinner(){
    document.querySelector(".spiner").classList.add("is-active");
    setTimeout(function(){
        window.location.reload();
    }, 2000);
}
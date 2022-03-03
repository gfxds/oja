import { Controller } from '@hotwired/stimulus';

/*
 * This will only fire on data-controller="form" attribute
 */
export default class extends Controller {
    connect() {
        
        let form = document.getElementsByTagName("form")[0];
        let formaction = form.getAttribute('action');
        let formmethod = form.getAttribute('method');
        let suc = document.getElementById("success")
        let err = document.getElementById("error")

        form.addEventListener("submit",async function (event) {
            event.preventDefault();
            suc.innerHTML = "";
            err.innerHTML = "";

            //make request
            let response = await fetch(formaction, {
                method: formmethod,
                body: new FormData(form)
            });

            let result = await response.json();

            if (result.code == 200){
                form.reset()
                suc.innerHTML = result.status;
                setTimeout(function(){
                    suc.innerHTML = "";
                },2000);
                return
            }

            err.innerHTML = result.error
        });
    }
}

import * as bootstrap from 'bootstrap';
import axios from 'axios';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

if(document.querySelector('.edit--amounts--btn')){
    const editAmountBtn = document.querySelector('.edit--amounts--btn')
    editAmountBtn.addEventListener('click', ()=> {
        console.log()
    })

}
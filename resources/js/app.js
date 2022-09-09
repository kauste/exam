import * as bootstrap from 'bootstrap';
import axios from 'axios';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

if(document.querySelector('.edit--amounts--btn')){
    const editAmountBtn = document.querySelector('.edit--amounts--btn')
    editAmountBtn.addEventListener('click', ()=> {
        const inputs = document.querySelectorAll('td > input');
        const orderId = document.querySelector('h2').dataset.orderId;
        const amounts = [];
            inputs.forEach(input => {
                const amount = 
                            {
                            'dish_id': input.name,
                            'amount' : input.value,
                            }
                amounts.push(amount);
            });
        axios.put(editAmountUrl, {amounts, 'orderId':orderId})
        .then(res =>{

            if(res.data.errors){
                const jsMessages = document.querySelector('.js--messages');
                jsMessages.classList.remove('d-none');
                let errors = '';
                res.data.errors.forEach( error => {
                    errors += '<li class="message m-0">' + error +'</li>';
                }
                )
                jsMessages.innerHTML = errors;

            };
        })
            
    })
}
// js--message
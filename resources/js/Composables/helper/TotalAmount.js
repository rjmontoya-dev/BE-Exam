export function getTotalAmount(items){
        let total = 0;
        let subTotal = items.value.map((item)=>(item.qty * item.products.price)); 
            subTotal.forEach(value=>{
                 total = total + value;
            }) 
        return total;
}
    
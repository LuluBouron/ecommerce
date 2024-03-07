window.onload = () => {
    let mainContent = document.querySelector('.main_content')
    let tbody = document.querySelector('tbody')
    let cart_total_amount =  document.querySelectorAll('.cart_total_amount')
    
    let cart = JSON.parse(mainContent?.dataset?.cart || false);

    console.log('coucou')
    const formatPrice = (price) => {
        return Intl.NumberFormat('en-US', { style: 'currency', currency: 'EUR' })
            .format(price);
    }

    const addFlashMessage = (message) => {
        // message de notification quand on ajoute un produit au panier
        const text = `
        <div class="alert alert-success" role="alert">
         ${message}! </div>

        `
        document.querySelector(".notification").innerHTML += text
        setTimeout(() => {
            document.querySelector(".notification").innerHTML = ""
        }, 2000)
        
    }
    
    const fetchData = async (requestUrl) =>{
        const response = await fetch(requestUrl)
        if(response.ok){
            // si la requête contient le mot clé 'add' alors on met ce message
            if(requestUrl.search('/add/') != -1){
                // add to cart
                addFlashMessage('Le produit a bien été ajouté à votre panier')
            }

            if(requestUrl.search('/remove/') != -1){
                // remove to cart
                addFlashMessage('Le produit a bien été supprimé de votre panier')
            }
        }
        return await response.json()
        
    }

    //récupérer les éléments du tbody pour ajout et remove les produits sans rechargement de la page
    const manageLink = async (event) => {
        event.preventDefault();
        const link = event.target.href ? event.target : event.target.parentNode 
        const requestUrl = link.href // => pour avoir directement l'URL qui permet l'ajout
        cart = await fetchData(requestUrl)
        initCart()
        //console.log(result)
    }

    const addEventListenerToLink = () => {
        const links = document.querySelectorAll('tbody a')
        links.forEach((link)=>{
            link.addEventListener("click", manageLink)
        })

        const add_to_cart_links = document.querySelectorAll('li.add-to-cart a')
        console.log(add_to_cart_links)
        add_to_cart_links.forEach((link)=>{
            link.addEventListener("click", manageLink)
        })

    }

    const initCart = () =>{
        // initialisation du panier
        if(!cart){ // si le panier n'est pas défini
            addEventListenerToLink()
            return
        }

        if(tbody){
            console.log('in')
            tbody.innerHTML = ""
            cart.items.forEach((item) => {   
                const { product, quantity, sub_total } = item
                //console.log(item)
                const content = ` <tr>
                <td class="product-thumbnail"><a><img width="50" alt="product1"
                                                        src="/assets/images/products/${product.imageUrls[0]}"></a>
                                            </td>
                                            <td data-title="Product" class="product-name"><a>${product.name}</a></td>
                                            <td data-title="Price" class="product-price">
                                                ${ formatPrice(product.soldePrice/100) }
                                            </td>
                                            <td data-title="Quantity" class="product-quantity">
                                                <div class="quantity">
                                                    <a href="/cart/remove/${product.id}/1">
                                                        <input type="button" value="-" class="minus">
                                                    </a>
                                                    <input type="text" name="quantity" value="${ quantity }" title="Qty" size="4" class="qty">
                                                    <a href="/cart/add/${product.id}/1">
                                                        <input type="button" value="+" class="plus">
                                                    </a>
                                                </div>
                                            </td>
                                            <td data-title="Total" class="product-subtotal">
                                                ${formatPrice(sub_total/100)} </td>
                                            <td data-title="Remove" class="product-remove">
                                                <a href="/cart/remove/${product.id}/${item.quantity}">
                                                    <i class="ti-close"></i>
                                                </a>
                                            </td>
                </tr>`
                tbody.innerHTML += content
            });

            cart_total_amount.forEach(cart_total_amount =>{  
                cart_total_amount.innerHTML = formatPrice(cart.sub_total/100)
            })
        }
        
        addEventListenerToLink()
    }
    //appel de la fonction
    initCart()
    

}
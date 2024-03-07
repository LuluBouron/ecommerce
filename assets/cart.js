window.onload = () => {
    let mainContent = document.querySelector('.main_content')
    let tbody = document.querySelector('tbody')
    let cart_total_amount =  document.querySelectorAll('.cart_total_amount')
    let cart = JSON.parse(mainContent?.dataset?.cart || false);
   

    const formatPrice = (price) => {
        return Intl.NumberFormat('en-US', { style: 'currency', currency: 'EUR' })
            .format(price);
    }

    const addFlashMessage = (message, status="sucess") => {
        // message de notification quand on ajoute un produit au panier
        const text = `
        <div class="alert alert-${status}" role="alert">
         ${message}! </div>

        `
        const audio = document.createElement("audio")
        audio.src = "/assets/audios/success.wav"

        audio.play()
        document.querySelector(".notification").innerHTML += text
        // message disparait au bout de 2 secs
        setTimeout(() => {
            document.querySelector(".notification").innerHTML = ""
        }, 2000)
        
    }
    
    const fetchData = async (requestUrl) =>{
        const response = await fetch(requestUrl)
        return await response.json()
        
    }
    //récupérer les éléments du tbody pour ajout et remove les produits sans rechargement de la page
    const manageLink = async (event) => {
        
        event.preventDefault();
        const link = event.target.href ? event.target : event.target.parentNode 
        const requestUrl = link.href // => pour avoir directement l'URL qui permet l'ajout
        // si la requête contient le mot clé 'add' alors on met ce message
        cart = await fetchData(requestUrl)
        // console.log(requestUrl.split('/')[5])
        const productId = requestUrl.split('/')[5]
       //console.log(productId)
        const product = await fetchData("/product/get/" +productId)
        //console.log(product)

        if(requestUrl.search('/add/') != -1){
           // add to cart
           if(product){
            addFlashMessage(`Le produit ${product.name} a bien été ajouté à votre panier`)
           }else {
            addFlashMessage('Le produit a bien été ajouté dans votre panier')
           }
           
           
        }

        if(requestUrl.search('/remove/') != -1){
            // remove to cart
            addFlashMessage('Le produit a bien été supprimé de votre panier', "danger")
        }

        initCart()
        
    }

    const addEventListenerToLink = () => {
        const links = document.querySelectorAll('tbody a')
        links.forEach((link)=>{
            link.addEventListener("click", manageLink)
        })

        const add_to_cart_links = document.querySelectorAll('li.add-to-cart a, a .item-remove, a.btn-addtocart')
 
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
            tbody.innerHTML = ""
            cart.items.forEach((item) => {   
                const { product, quantity, sub_total } = item
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
    // gérer le panier en en-tête
    const updateHeaderCart = async () =>{

        const cart_count = document.querySelector(".cart_count")
        const cart_list = document.querySelector(".cart_list")
        const cart_price_value = document.querySelector(".cart_price_value")
        
        if(!cart){ 
           // cart data not found
           console.log('panier pas trouvé')
           cart = await fetchData("/cart/get")
           
        }
        
        else {
            console.log('panier ok')
            // cart data found
            cart_count.innerHTML = cart.cart_count
            cart_list.innerHTML = ""
            cart_price_value.innerHTML = formatPrice(cart.sub_total/100) 

            cart.items.forEach(item =>{
                
                const {product, quantity, sub_total} = item
                console.log(product)
                cart_list.innerHTML += ` 
                    <li>
                        <a  href="/cart/remove/${product.id}/${quantity}" class="item_remove">
                        <i  class="ion-close"></i></a>
                        
                        <a href="/product/${product.slug}">
                        <img width="50" height="50" alt="cart_thumb1" src="/assets/images/products/${product.imageUrls[0]}">
                       ${product.name} </a>
                        <span  class="cart_quantity"> ${quantity}  x
                        <span  class="cart_amount">  
                        <span class="price_symbole">${formatPrice(product.soldePrice/100)}</span>
                        </span></span>
                    </li>`
            })
        }
        addEventListenerToLink()


    }
    //appel de la fonction
    initCart()
    updateHeaderCart()
    
}
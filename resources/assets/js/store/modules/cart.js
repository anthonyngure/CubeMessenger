const state = {
  added: [],
  checkoutStatus: null
}

const getters = {
  checkoutStatus: state => state.checkoutStatus,
  cartProducts: state => state.added,
  cartProductsTotal: (state, getters) => {
    return state.added.length
  },
  cartTotal: (state, getters) => {
    return getters.cartProducts.reduce((total, cartProduct) => {
      return total + cartProduct.product.price * cartProduct.quantity
    }, 0)
  }
}

// actions
const actions = {
  checkout ({commit, state}, products) {
    const savedCartItems = [...state.added]
    commit('setCheckoutStatus', null)
    // empty cart
    commit('setCartItems', {items: []})
    shop.buyProducts(
      products,
      () => commit('setCheckoutStatus', 'successful'),
      () => {
        commit('setCheckoutStatus', 'failed')
        // rollback to the cart saved before sending the request
        commit('setCartItems', {items: savedCartItems})
      }
    )
  },
  
  addProductToCart ({state, commit}, payLoad) {
    //console.info('addProductToCart')
    //console.info(payLoad.product)
    //console.info(payLoad.quantity)
    commit('setCheckoutStatus', null)
    const cartItem = state.added.find(item => item.product.id === payLoad.product.id)
    if (!cartItem) {
      commit('pushProductToCart', payLoad)
    } else {
      commit('incrementItemQuantity', payLoad)
    }
    
    //Increment the number of items in cart for the product
    commit('incrementProductQuantityInCart', payLoad)
    // remove 1 item from stock
    //commit('decrementProductInventory', {id: product.id})
  },
  removeProductFromCart ({state, commit}, payLoad) {
    commit('removeProduct', payLoad)
    //We remove the product quantity in cart when it is removed
    commit('clearProductQuantityInCart', payLoad)
  },
  removeAllProductsFromCart({state, commit}){
    commit('clearCart')
    commit('clearAllProductsQuantityInCart')
  }
}

// mutations
const mutations = {
  clearCart(state){
    state.added = []
  },
  removeProduct(state, payLoad){
    //console.info('removeProductFromCart')
    const cartItem = state.added.find(item => item.product.id === payLoad.product.id)
    //const index = state.added.indexOf(cartItem);
    if (cartItem) {
      state.added.splice(cartItem, 1)
    }
  },
  pushProductToCart (state, payLoad) {
    state.added.push({
      product: payLoad.product,
      quantity: payLoad.quantity
    })
  },
  
  incrementItemQuantity (state, payLoad) {
    const cartItem = state.added.find(item => item.product.id === payLoad.product.id)
    cartItem.quantity += payLoad.quantity
  },
  
  setCartItems (state, {items}) {
    state.added = items
  },
  
  setCheckoutStatus (state, status) {
    state.checkoutStatus = status
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
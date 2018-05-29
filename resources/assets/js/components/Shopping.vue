<template >
  <v-layout row
            wrap >
    <v-flex xs12 >
      <v-tabs fixed-tabs
              v-model="currentTab"
              show-arrows
              lazy
              grow >
        <v-tabs-slider color="yellow" ></v-tabs-slider >
        <v-tab v-for="category in categories"
               :key="category.id"
               :href="`#${category.id}`" >
          {{category.name}}
        </v-tab >
      </v-tabs >
      <v-card >
        <v-container fluid
                     grid-list-md >
          <v-data-iterator
            content-tag="v-layout"
            row
            wrap
            :items="products"
            :rows-per-page-items="rowsPerPageItems"
            :pagination.sync="pagination" >
            <v-flex slot="item"
                    slot-scope="props"
                    xs3 >
              <v-card >
                <v-card-media
                  :src="$utils.imageUrl(props.item.image)"
                  height="150px" >
                  <v-container fill-height
                               fluid >
                    <v-layout fill-height >
                      <v-flex xs12
                              align-end
                              flexbox >
                        <span class="subheading white--text" >{{props.item.name}}</span >
                      </v-flex >
                    </v-layout >
                  </v-container >
                </v-card-media >
                
                <v-tooltip top
                           lazy
                           max-width="175px" >
                  <v-btn flat
                         block
                         slot="activator"
                         class="mt-0 mb-0" >
                    Ksh. {{props.item.price}}
                    <v-icon small
                            right >info
                    </v-icon >
                  </v-btn >
                  <span >{{props.item.description}}</span >
                </v-tooltip >
                
                <v-card-actions v-if="isDepartmentUser()" >
                  <v-badge small
                           v-if="props.item.quantityInCart"
                           color="accent"
                           overlap >
                    <span slot="badge" >{{props.item.quantityInCart}}</span >
                    <v-btn icon >
                      <v-icon color="primary" >shopping_basket</v-icon >
                    </v-btn >
                  </v-badge >
                  <v-spacer ></v-spacer >
                  <v-btn flat
                         color="primary"
                         small
                         outline
                         @click.native="selectedProduct = props.item" >
                    <v-icon left
                            small >shopping_cart
                    </v-icon >
                    Add to cart
                  </v-btn >
                </v-card-actions >
              </v-card >
            </v-flex >
          </v-data-iterator >
        </v-container >
      </v-card >
    
    </v-flex >
    
    <add-to-cart-dialog :product="selectedProduct"
                        @onCancel="selectedProduct = null" >
    </add-to-cart-dialog >
    
    <cart-dialog ></cart-dialog >
  
  </v-layout >
</template >

<script >
import ConnectionManager from './ConnectionManager'
import AddToCartDialog from './AddToCartDialog'
import Base from './Base.vue'
import CartDialog from './CartDialog'
import {mapGetters} from 'vuex'

export default {
  extends: Base,
  components: {
    CartDialog,
    AddToCartDialog,
    ConnectionManager
  },
  name: 'Shopping',
  data () {
    return {
      selectedProduct: null,
      currentTab: null,
      rowsPerPageItems: [12],
      pagination: {
        rowsPerPage: 12
      }
    }
  },
  watch: {
    categories (val) {
      if (val && val.length) {
        this.currentTab = val[0].id + ''
      }
    }
  },
  computed: {
    products () {
      //console.info(this.currentTab)
      //console.info('Computing products')
      const category = this.categories.find(category => category.id === parseInt(this.currentTab))
      return category ? category.products : []
    },
    ...mapGetters({
      categories: 'allCategories'
    })
  },
  created () {
    this.$store.dispatch('getAllCategories')
  }
}
</script >

<style scoped >

</style >
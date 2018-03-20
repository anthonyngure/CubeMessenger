<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-card>
                <connection-manager ref="connectionManager"
                                    @onConnectionChange="onConnectionChange"
                                    @onSuccess="onConnectionManagerSuccess">
                </connection-manager>

                <v-card-text>
                    <v-toolbar color="white" tabs flat dense>
                        <v-text-field
                                prepend-icon="search" append-icon="mic" label="Search" solo-inverted class="mx-3" flat>
                        </v-text-field>
                        <v-tabs fixed-tabs v-model="currentTab"
                                slider-color="accent"
                                show-arrows
                                grow
                                slot="extension"
                                color="transparent">
                            <v-tab v-for="category in categories"
                                   :key="category.id"
                                   :href="`#${category.id}`">
                                {{category.name}}
                            </v-tab>
                        </v-tabs>

                    </v-toolbar>

                    <v-container fluid grid-list-md>
                        <v-layout row wrap>
                            <v-flex xs3 v-for="(product, n) in products" :key="n">
                                <v-card>
                                    <v-card-media
                                            :src="$utils.imageUrl(product.image)"
                                            height="200px">
                                        <v-container fill-height fluid>
                                            <v-layout fill-height>
                                                <v-flex xs12 align-end flexbox>
                                                    <span class="headline white--text">{{product.name}}</span>
                                                </v-flex>
                                            </v-layout>
                                        </v-container>
                                    </v-card-media>
                                    <v-card-title primary-title>
                                        <div>
                                            <div class="headline">Ksh. {{product.price}}</div>
                                            <span class="grey--text">{{product.description}}</span>
                                        </div>
                                    </v-card-title>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn flat color="primary" outline
                                               @click.native="selectedProduct = product">
                                            <v-icon left>shopping_cart</v-icon>
                                            Add to cart
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-flex>
                            <infinite-loading spinner="waveDots"
                                              style="flex: 1 1 auto;"
                                              :distance="distance"
                                              ref="infiniteLoading"
                                              @infinite="infiniteHandler">
                                <span slot="no-more">
                                    There is no more items in this category
                                </span>
                            </infinite-loading>
                            <v-flex xs12></v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-flex>

        <add-to-cart-dialog :product="selectedProduct"
                            @onClose="selectedProduct = null"
                            @onConfirmAddToCart="onConfirmAddToCart">
        </add-to-cart-dialog>

    </v-layout>
</template>

<script>
  import EventBus from '../event-bus'
  import ConnectionManager from './ConnectionManager'
  import InfiniteLoading from 'vue-infinite-loading'
  import AddToCartDialog from './AddToCartDialog'

  export default {
    components: {
      AddToCartDialog,
      ConnectionManager, InfiniteLoading
    },
    name: 'shopping',
    data () {
      return {
        selectedProduct: null,
        currentTab: null,
        categories: [],
        products: [],
        before: 0,
        after: 0,
        perPage: 8,
        recent: true,
        distance: 10
      }
    },
    watch: {
      currentTab (currentTab) {
        this.products = []
        this.recent = true
        this.before = 0
        this.after = 0
        this.$nextTick(() => {
          this.$utils.log(currentTab)
          this.$utils.log(this.distance)
          this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset')
          this.$refs.infiniteLoading.attemptLoad()

          /*if (this.distance === 10) {
            //Has already attempted loading
            //Should now reset
            this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset')
          } else {
            //Has note yet attempted to load
            this.distance = 10
            this.$refs.infiniteLoading.attemptLoad()
          }*/
        })
      }
    },
    methods: {
      onConfirmAddToCart (quantity) {
        let that = this
        let item = this.products.find(function (element) {
          return element.id === that.selectedProduct.id
        })
        let index = this.products.indexOf(item)
        item.isInCart = true
        item.quantity = quantity
        this.products[index] = item
        EventBus.$emit('onAddRemoveFromCart', item)
        this.selectedProduct = null
      },
      onConnectionChange (status) {

      },
      onConnectionManagerSuccess (response) {
        this.categories = this.categories.concat(response.data.data)
        this.currentTab = '' + this.categories[0].id
      },
      infiniteHandler ($state) {
        this.axios.get('shopProducts', {
          params: {
            recent: this.recent,
            before: this.before,
            after: this.after,
            perPage: this.perPage,
            category: this.currentTab,
          }
        }).then(response => {

          this.recent = false
          this.before = response.data.cursors.before
          this.after = response.data.cursors.after
          this.products = this.products.concat(response.data.data)

          this.$utils.log(this.products)

          //State handling
          if (response.data.data.length === 0) {
            $state.complete()
          } else {
            $state.loaded()
          }
        }).catch(error => {
          this.$utils.log(error)
        })
      },
    },
    mounted () {
      this.$refs.connectionManager.index('shopCategories')
    }
  }
</script>

<style scoped>

</style>
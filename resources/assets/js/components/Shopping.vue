<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-card>
                <connection-manager ref="connectionManager"></connection-manager>
                <v-card-text>
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
                    <v-container fluid grid-list-md>
                        <v-layout row wrap>
                            <v-flex xs2 v-for="(product, n) in products" :key="n">
                                <v-card>
                                    <v-card-media
                                            :src="$utils.imageUrl(product.image)"
                                            height="150px">
                                        <v-container fill-height fluid>
                                            <v-layout fill-height>
                                                <v-flex xs12 align-end flexbox>
                                                    <span class="subheading white--text">{{product.name}}</span>
                                                </v-flex>
                                            </v-layout>
                                        </v-container>
                                    </v-card-media>

                                    <v-tooltip top lazy max-width="175px">
                                        <v-btn flat block slot="activator">
                                            Ksh. {{product.price}}
                                            <v-icon small right>info</v-icon>
                                        </v-btn>
                                        <span>{{product.description}}</span>
                                    </v-tooltip>

                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-tooltip v-if="product.clientOrder" top lazy max-width="175px">
                                            <v-btn flat color="accent" small outline slot="activator">
                                                <v-icon left small>access_time</v-icon>
                                                Pending
                                            </v-btn>
                                            <span>
                                                <span>Quantity: {{product.clientOrder.quantity}}</span><br/>
                                                <span>Status: {{product.clientOrder.status}}</span><br/>
                                                <span v-if="product.clientOrder.status === 'CONFIRMED'">
                                                    Date Confirmed: {{product.clientOrder.confirmedAt}}
                                                    <br/>
                                                </span>
                                                <span v-else>Date Ordered: {{product.clientOrder.createdAt}}</span><br/>
                                            </span>
                                        </v-tooltip>
                                        <v-btn v-else flat color="primary" small outline
                                               @click.native="selectedProduct = product">
                                            <v-icon left small>shopping_basket</v-icon>
                                            Order
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
                            @onClose="onCloseOderDialog">
        </add-to-cart-dialog>

    </v-layout>
</template>

<script>
  import EventBus from '../event-bus'
  import ConnectionManager from './ConnectionManager'
  import InfiniteLoading from 'vue-infinite-loading'
  import AddToCartDialog from './AddToCartDialog'
  import Base from './Base.vue'

  export default {
    extends: Base,
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
        perPage: 12,
        recent: true,
        distance: 10
      }
    },
    watch: {
      currentTab (val) {
        if (val) {
          this.refresh()
        }
      }
    },
    methods: {
      refresh () {
        this.products = []
        this.recent = true
        this.before = 0
        this.after = 0
        this.$nextTick(() => {
          this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset')
          this.$refs.infiniteLoading.attemptLoad()
        })
      },
      onCloseOderDialog (successful) {
        this.selectedProduct = null
        if (successful) {
          this.refresh()
        }
      },
      infiniteHandler ($state) {
        this.axios.get('shopProducts', {
          params: {
            recent: this.recent,
            before: this.before,
            after: this.after,
            perPage: this.perPage,
            shopCategoryId: this.currentTab,
          }
        }).then(response => {

          this.recent = false
          this.before = response.data.cursors.before
          this.after = response.data.cursors.after
          this.products = this.products.concat(response.data.data)

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
      loadShopCategories () {
        let that = this
        this.$refs.connectionManager.get('shopCategories', {
          onSuccess (response) {
            that.categories = that.categories.concat(response.data.data)
            that.currentTab = '' + that.categories[0].id
          }
        })
      }
    },
    mounted () {
      this.loadShopCategories()
    }
  }
</script>

<style scoped>

</style>
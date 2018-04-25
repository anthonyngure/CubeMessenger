<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-tabs fixed-tabs
                    v-model="currentTab"
                    show-arrows
                    lazy
                    grow>
                <v-tabs-slider color="yellow"></v-tabs-slider>
                <v-tab v-for="category in categories"
                       :key="category.id"
                       :href="`#${category.id}`">
                    {{category.name}}
                </v-tab>
            </v-tabs>
            <v-card>
                <v-container fluid grid-list-md>
                    <connection-manager ref="connectionManager" v-model="loading">
                    </connection-manager>
                    <v-data-iterator
                            content-tag="v-layout"
                            row
                            wrap
                            :items="products"
                            :no-data-text="loading ? '' : 'No data available'"
                            :rows-per-page-items="rowsPerPageItems"
                            :pagination.sync="pagination">
                        <v-flex slot="item"
                                slot-scope="props"
                                xs3>
                            <v-card>
                                <v-card-media
                                        :src="$utils.imageUrl(props.item.image)"
                                        height="150px">
                                    <v-container fill-height fluid>
                                        <v-layout fill-height>
                                            <v-flex xs12 align-end flexbox>
                                                <span class="subheading white--text">{{props.item.name}}</span>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card-media>

                                <v-tooltip top lazy max-width="175px">
                                    <v-btn flat block slot="activator" class="mt-0 mb-0">
                                        Ksh. {{props.item.price}}
                                        <v-icon small right>info</v-icon>
                                    </v-btn>
                                    <span>{{props.item.description}}</span>
                                </v-tooltip>

                                <v-card-actions v-if="isDepartmentUser()">
                                    <v-badge small v-if="props.item.clientOrders.length" color="accent" overlap>
                                        <span slot="badge">{{props.item.clientOrders.length}}</span>
                                        <v-btn icon>
                                            <v-icon color="primary">shopping_basket</v-icon>
                                        </v-btn>
                                    </v-badge>
                                    <v-spacer></v-spacer>
                                    <v-btn flat color="primary" small outline
                                           @click.native="selectedProduct = props.item">
                                        <v-icon left small>shopping_cart</v-icon>
                                        Order
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-flex>
                    </v-data-iterator>
                </v-container>
            </v-card>

        </v-flex>

        <add-to-cart-dialog :product="selectedProduct"
                            @onClose="onCloseOderDialog">
        </add-to-cart-dialog>

    </v-layout>
</template>

<script>
  import ConnectionManager from './ConnectionManager'
  import AddToCartDialog from './AddToCartDialog'
  import Base from './Base.vue'

  export default {
    extends: Base,
    components: {
      AddToCartDialog,
      ConnectionManager
    },
    name: 'shopping',
    data () {
      return {
        loading: false,
        selectedProduct: null,
        currentTab: null,
        categories: [],
        products: [],
        before: 0,
        after: 0,
        perPage: 40,
        recent: true,
        rowsPerPageItems: [12],
        pagination: {
          rowsPerPage: 12
        },
      }
    },
    watch: {
      currentTab (val) {
        if (val) {
          //Reset cursors
          this.recent = true
          this.before = 0
          this.after = 0
          this.products = []
          this.refresh()
        }
      }
    },
    methods: {
      refresh () {
        let that = this
        that.products = []
        that.$refs.connectionManager.get('shopProducts', {
          onSuccess (response) {
            that.recent = false
            that.before = response.data.cursors.before
            that.after = response.data.cursors.after
            that.products = that.products.concat(response.data.data)
          }
        }, {
          recent: that.recent,
          before: that.before,
          after: that.after,
          perPage: that.perPage,
          shopCategoryId: that.currentTab,
        })
      },
      onCloseOderDialog (successful) {
        this.selectedProduct = null
        if (successful) {
          this.recent = true
          this.before = 0
          this.after = 0
          this.products = []
          this.refresh()
        }
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
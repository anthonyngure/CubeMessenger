<template>
    <v-dialog
            v-model="dialog"
            max-width="600px"
            lazy>
        <v-card>
            <v-toolbar card dark dense color="primary">
                <v-icon>shopping_cart</v-icon>
                <v-toolbar-title>Add to cart</v-toolbar-title>
            </v-toolbar>
            <v-card-media
                    v-if="product"
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
            <v-card-title primary-title v-if="product">
                <div>
                    <div class="headline">Ksh. {{product.price}}</div>
                    <span class="grey--text">{{product.description}}</span>
                </div>
            </v-card-title>
            <v-card-text>
                <v-text-field
                        v-model="quantity"
                        required
                        label="Enter quantity"
                        mask="###"
                        placeholder="Quantity">
                </v-text-field>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn flat color="red" @click.native="$emit('onClose')">
                    Cancel
                </v-btn>
                <v-btn color="primary" @click.native="$emit('onConfirmAddToCart', quantity)" :disabled="!quantity">
                    <v-icon left>check</v-icon>
                    Confirm
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>


  export default {
    name: 'add-to-cart-dialog',
    props: {
      product: {
        required: true
      }
    },
    watch: {
      product (val) {
        this.dialog = !!val
      }
    },
    data () {
      return {
        dialog: false,
        quantity: false,
      }
    },
  }
</script>

<style scoped>

</style>
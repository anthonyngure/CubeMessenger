<template>
    <v-dialog v-model="dialog"
              lazy
              persistent
              width="450px">
        <v-card v-if="dialog">
            <v-toolbar card dense dark color="primary">
                <v-btn icon @click.native="onClose">
                    <v-icon>close</v-icon>
                </v-btn>
                <v-toolbar-title>Item QR Code</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn flat @click.native="printQR">Print</v-btn>
                    <v-btn flat @click.native="onClose">Cancel</v-btn>
                </v-toolbar-items>
                <v-menu bottom right offset-y>
                    <v-btn slot="activator" dark icon>
                        <v-icon>more_vert</v-icon>
                    </v-btn>
                    <v-list dense>
                        <v-list-tile @click="onClose">Cancel</v-list-tile>
                    </v-list>
                </v-menu>
            </v-toolbar>
            <v-card-text>
                <q-r-code id="qr-code" :text="JSON.stringify(itemData)" :size="400"></q-r-code>
                <v-list three-line>
                    <v-list-tile avatar>
                        <v-list-tile-avatar>
                            <img :src="'/storage/'+item.courierOption.icon">
                        </v-list-tile-avatar>
                        <v-list-tile-content>
                            <v-list-tile-title class="body-2">
                                <b>{{item.quantity}} -
                                    {{item.courierOption.name+ (item.quantity === 1 ? '': 's')}}
                                </b>
                            </v-list-tile-title>
                            <v-list-tile-sub-title class="caption primary--text">
                                <b>To: </b>{{item.destinationName}}
                            </v-list-tile-sub-title>
                            <v-list-tile-sub-title class="caption accent--text">
                                {{item.destinationFormattedAddress}}
                            </v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
  import QRCode from 'vue-qrcode-component'
  import printJS from 'print-js'

  export default {
    components: {QRCode},
    name: 'delivery-item-q-r-dialog',
    props: {
      item: {
        required: true,
      }
    },
    watch: {
      item (item) {
        if (item) {
          this.dialog = true
          this.itemData = {
            id: item.id
          }
        } else {
          this.dialog = false
          this.itemData = null
        }
      },
    },
    data () {
      return {
        dialog: false,
        itemData: null
      }
    },
    methods: {
      onClose () {
        this.$emit('onClose')
      },
      printQR () {
        //documentTitle
        printJS(
          {
            printable: 'qr-code',
            type: 'html',
            header: this.item.quantity + ' - ' + this.item.courierOption.name,
            documentTitle: 'Client QR Code (NAME: ' + this.$auth.user().client.name + ', ID: ' + this.$auth.user().client.id + ')'
          })
      }
    },
  }
</script>

<style scoped>

</style>
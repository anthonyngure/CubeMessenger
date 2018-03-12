<template>
    <v-dialog v-model="dialog"
              lazy
              persistent
              width="800px">
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
                <v-layout row wrap id="qr-code" align-center justify-center>
                    <template v-for="i in item.quantity">
                        <v-flex md3 :key="i" style="border: thin black dashed;">
                            <q-r-code
                                    class="ma-4"
                                    :text="item.quantity > 1 ? JSON.stringify({id:item.id, count: i}) : JSON.stringify({id:item.id})"
                                    :size="135">
                            </q-r-code>
                            <div class="primary py-1" v-if="item.quantity > 1">
                                <p class="text-xs-center pt-1">{{item.courierOption.name+' '+i}}
                                    to <b>{{item.destinationName}}</b>
                                </p>
                            </div>
                        </v-flex>
                        <v-flex xs12 v-if="(i%16) === 0" :key="i+item.quantity">
                            <div class="html2pdf__page-break"></div>
                        </v-flex>
                    </template>

                </v-layout>
                <v-list three-line>
                    <v-list-tile avatar>
                        <v-list-tile-avatar>
                            <img :src="'/storage/'+item.courierOption.icon">
                        </v-list-tile-avatar>
                        <v-list-tile-content>
                            <v-list-tile-title class="body-2">
                                <b>{{item.quantity > 1 ? item.courierOption.pluralName :
                                    item.courierOption.name}}
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
  import html2pdf from 'html2pdf.js'

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
        let courierOptionName = this.item.quantity > 1 ? this.item.courierOption.pluralName : this.item.courierOption.name
        let element = document.getElementById('qr-code')
        html2pdf(element, {
          margin: 1,
          filename: this.item.quantity + ' ' + courierOptionName + ' to ' + this.item.destinationName + '.pdf',
          image: {type: 'jpeg', quality: 0.99},
          html2canvas: {dpi: 320, letterRendering: true},
          jsPDF: {unit: 'cm', format: 'letter', orientation: 'portrait'}
        })

        let that = this
        setTimeout(function () {
          that.onClose()
        }, 1000)

        /*printJS(
          {
            printable: 'qr-code',
            maxWidth: 400,
            showModal: true,
            type: 'html',
            header: this.item.quantity + ' ' + courierOptionName + ' to ' + this.item.destinationName,
            documentTitle: 'Client QR Code (NAME: ' + this.$auth.user().client.name + ', ID: ' + this.$auth.user().client.id + ')',
            onLoadingStart: () => {
              this.onClose()
            }
          })*/
      }
    },
  }
</script>

<style scoped>


</style>
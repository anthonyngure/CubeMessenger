<template>
    <v-layout row wrap>
        <v-flex xs12>
            <!--<h2 class="title px-3 py-4" style="text-transform: uppercase">
                Reports -
                <small>{{$auth.user().client.name}} - ({{$auth.user().client.email}})</small>
            </h2>-->
            <v-tabs fixed-tabs
                    v-model="currentTab"
                    lazy
                    grow
                    icons-and-text>
                <v-tabs-slider color="yellow"></v-tabs-slider>
                <v-tab v-for="(tab, index) in tabs" :href="`#${tab.id}`" :key="index">
                    {{tab.title}}
                    <v-icon>{{tab.icon}}</v-icon>
                </v-tab>
            </v-tabs>

            <v-card class="pt-3" v-if="currentItem">
                <v-toolbar color="transparent" dense flat card>
                    <v-btn small flat outline color="accent">
                        <v-icon left>account_balance_wallet</v-icon>
                        SPENT KES 0.00
                    </v-btn>
                    <!--<v-icon left>account_balance_wallet</v-icon>
                    <v-toolbar-title class="text-xs-center">SPENT KES 200.52</v-toolbar-title>-->
                    <v-text-field
                            class="ml-5"
                            append-icon="search"
                            label="Search"
                            single-line
                            hide-details
                            v-model="search">
                    </v-text-field>
                    <v-menu offset-y>
                        <v-btn small flat outline color="primary" slot="activator">
                            <v-icon left>date_range</v-icon>
                            {{month}}
                        </v-btn>
                        <v-date-picker
                                v-model="month"
                                type="month"
                                landscape
                                :min="minMonth"
                                :max="maxMonth">
                        </v-date-picker>
                    </v-menu>

                    <v-btn small flat outline color="primary">
                        <v-icon left>file_download</v-icon>
                        Download
                    </v-btn>
                    <v-btn small flat outline color="primary">
                        <v-icon left>refresh</v-icon>
                        Refresh
                    </v-btn>
                </v-toolbar>
                <v-data-table
                        :headers="currentItem.headers"
                        :items="items"
                        :search="search"
                        :rows-per-page-items="rowsPerPageItems"
                        :pagination.sync="pagination">
                    <template slot="items" slot-scope="props">

                        <td class="text-xs-center" v-for="(header, index) in currentItem.headers" :key="index">
                            <!--{{ props.item[header.value] }}-->
                            {{props.item[index]}}
                        </td>
                    </template>
                </v-data-table>
            </v-card>
        </v-flex>

    </v-layout>
</template>

<script>
  import Base from './Base.vue'
  import DateInput from './DateInput'
  import moment from 'moment'

  export default {
    components: {DateInput},
    name: 'dashboard',
    extends: Base,
    data () {
      return {
        tabs: [
          {
            icon: 'data_usage', title: 'Ledger', id: 'ledger',
            headers: [
              {text: 'Id', sortable: false, value: 'item'},
              {text: 'Amount', sortable: false, value: 'quantity'},
              {text: 'Description', sortable: false, value: 'quantity'},
              {text: 'Date/Time', sortable: false, value: 'quantity'},
            ],
          },
          {
            icon: 'schedule', title: 'Subscriptions', id: 'subscriptions',
            headers: [
              {text: 'Item', sortable: false, value: 'item'},
              {text: 'Quantity', sortable: false, value: 'quantity'},
              {text: 'Cost', sortable: false, value: 'quantity'},
              {text: 'Delivery Date/Time', sortable: false, value: 'quantity'},
              {text: 'Received By', sortable: false, value: 'quantity'},
            ],
          },
          {
            icon: 'shopping_cart', title: 'Shopping', id: 'shopping',
            headers: [
              {text: 'Item', sortable: false, value: 'item'},
              {text: 'Quantity', sortable: false, value: 'quantity'},
              {text: 'Cost', sortable: false, value: 'quantity'},
              {text: 'Department', sortable: false, value: 'quantity'},
              {text: 'Date/Time', sortable: false, value: 'quantity'},
              {text: 'Approved By', sortable: false, value: 'quantity'},
              {text: 'Approved Date/Time', sortable: false, value: 'quantity'},
              {text: 'Delivery Date/Time', sortable: false, value: 'quantity'},
              {text: 'Received By', sortable: false, value: 'quantity'},
            ],
          },
          {
            icon: 'computer', title: 'IT Services', id: 'it',
            headers: [
              {text: 'Details', sortable: false, value: 'item'},
              {text: 'Cost', sortable: false, value: 'quantity'},
              {text: 'Requested By', sortable: false, value: 'quantity'},
              {text: 'Approved By', sortable: false, value: 'quantity'},
              {text: 'Attended Date/Time', sortable: false, value: 'quantity'},
              {text: 'Finished Date/Time', sortable: false, value: 'quantity'},
              {text: 'Duration', sortable: false, value: 'quantity'},
              {text: 'Confirmed By', sortable: false, value: 'quantity'},
            ],
          },
          {
            icon: 'build', title: 'Repair Services', id: 'repairs',
            headers: [
              {text: 'Details', sortable: false, value: 'item'},
              {text: 'Cost', sortable: false, value: 'quantity'},
              {text: 'Requested By', sortable: false, value: 'quantity'},
              {text: 'Approved By', sortable: false, value: 'quantity'},
              {text: 'Attended Date/Time', sortable: false, value: 'quantity'},
              {text: 'Finished Date/Time', sortable: false, value: 'quantity'},
              {text: 'Duration', sortable: false, value: 'quantity'},
              {text: 'Confirmed By', sortable: false, value: 'quantity'},
            ],
          },
          {
            icon: 'local_shipping', title: 'Courier', id: 'courier',
            headers: [
              {text: 'Item(s)', sortable: false, value: 'item'},
              {text: 'Cost', sortable: false, value: 'quantity'},
              {text: 'Requested By', sortable: false, value: 'quantity'},
              {text: 'Approved By', sortable: false, value: 'quantity'},
              {text: 'Origin', sortable: false, value: 'item'},
              {text: 'Destination', sortable: false, value: 'quantity'},
              {text: 'Date/Time', sortable: false, value: 'quantity'},
              {text: 'Pick Up Date/Time', sortable: false, value: 'quantity'},
              {text: 'Drop Off Date/Time', sortable: false, value: 'quantity'},
              {text: 'Duration', sortable: false, value: 'quantity'},
              {text: 'Recipient name/contact', sortable: false, value: 'quantity'}
            ],
          },
        ],
        search: '',
        month: null,
        minMonth: null,
        maxMonth: null,
        rowsPerPageItems: [6, 10, 20],
        pagination: {
          rowsPerPage: 6
        },
        currentTab: null,
        currentItem: null,
        items: []
      }
    },
    methods: {
      refresh () {

      }
    },
    watch: {
      month (month) {
        if (month && this.currentTab && !this.connecting) {
          this.refresh()
        }
      },
      currentTab (val) {
        if (this.month && val && !this.connecting) {
          this.currentItem = this.tabs.find(function (element) {
            return element.id === val
          })
          this.refresh()
        }
      }
    },
    mounted () {
      let dateClientJoined = moment(this.$auth.user().client.createdAt)
      this.minMonth = dateClientJoined.year() + '-' + (dateClientJoined.month())
      let today = moment()
      this.maxMonth = today.year() + '-' + (today.month() + 2)
      let todayMonth = today.month()
      if (todayMonth < 10) {
        todayMonth = '0' + todayMonth
      }
      this.month = today.year() + '-' + todayMonth
      this.currentTab = 'ledger'
    }

  }
</script>

<style scoped>

</style>
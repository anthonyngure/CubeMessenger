<template>
    <v-layout row wrap>
        <v-flex xs12>

            <v-tabs fixed-tabs
                    v-model="currentTab"
                    lazy
                    grow
                    icons-and-text>
                <v-tabs-slider color="yellow"></v-tabs-slider>
                <v-tab v-for="(tab, index) in tabItems" :href="`#${tab.id}`" :key="index">
                    {{tab.title}}
                    <v-icon>{{tab.icon}}</v-icon>
                </v-tab>
            </v-tabs>

            <connection-manager ref="connectionManager" v-model="connecting">
            </connection-manager>

            <v-card class="pt-3" v-if="currentTabItem">
                <v-toolbar color="transparent" dense flat card>
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
                    <v-btn small flat outline @click="refresh" color="primary">
                        <v-icon left>refresh</v-icon>
                        Refresh
                    </v-btn>
                </v-toolbar>

                <v-data-table
                        :headers="currentTabItem.headers"
                        :items="items"
                        :search="search"
                        :rows-per-page-items="rowsPerPageItems"
                        :pagination.sync="pagination">
                    <template slot="items" slot-scope="props">

                        <td class="text-xs-left" v-for="(header, index) in currentTabItem.headers" :key="index">
                            {{ header.isMoney ? $utils.formatMoney(props.item[header.value]) : props.item[header.value]
                            }}
                            <!--{{props.item[index]}}-->
                            <!--{{props.item}}-->
                            <!--{{header.value}}-->
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
  import ConnectionManager from './ConnectionManager'

  export default {
    components: {ConnectionManager, DateInput},
    name: 'ClientDashboard',
    extends: Base,
    data () {
      return {
        tabItems: [
          {
            icon: 'data_usage', title: 'Bills', id: 'bills',
            headers: [
              {text: 'Id', sortable: false, value: 'id'},
              {text: 'Amount', sortable: false, value: 'amount', isMoney: true},
              {text: 'Status', sortable: false, value: 'status'},
              {text: 'Description', sortable: false, value: 'description'},
              {text: 'Date/Time', sortable: false, value: 'createdAt'},
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
        connecting: false,
        month: null,
        minMonth: null,
        maxMonth: null,
        rowsPerPageItems: [6, 10, 20],
        pagination: {
          rowsPerPage: 6
        },
        currentTab: null,
        currentTabItem: null,
        items: [],
      }
    },
    methods: {
      refresh () {
        this.items = []
        let that = this
        this.$refs.connectionManager.get('reports', {
          onSuccess (response) {
            that.items = that.items.concat(response.data.data)
          }
        }, {filter: this.currentTabItem.id})
      }
    },
    watch: {
      month (month) {
        if (month && this.currentTabItem && !this.connecting) {
          this.refresh()
        }
      },
      currentTab (val) {
        if (this.month && val && !this.connecting) {
          this.currentTabItem = this.tabItems.find(function (element) {
            return element.id === val
          })
          if (this.currentTabItem) {
            this.refresh()
          }
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
      this.currentTab = 'bills'
    }

  }
</script>

<style scoped>

</style>